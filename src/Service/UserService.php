<?php
/**
 * Created by PhpStorm.
 * User: Mladen
 * Date: 26.1.2019.
 * Time: 14:17
 */

namespace App\Service;

use App\Dto\Response\Transformer\UserRepoResponseDtoTransformer;
use App\Dto\Response\Transformer\UserResponseDtoTransformer;
use App\Dto\Response\UserLanguageResponseDto;
use App\Dto\Response\UserRepoResponseDto;
use App\Dto\Response\UserResponseDto;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var UserResponseDtoTransformer
     */
    private $userResponseDtoTransformer;

    /**
     * @var UserRepoResponseDtoTransformer
     */
    private $userRepoResponseDtoTransformer;

    public function __construct(
        HttpClientInterface $client,
        UserResponseDtoTransformer $userResponseDtoTransformer,
        UserRepoResponseDtoTransformer $userRepoResponseDtoTransformer
    ) {
        $this->client = $client;
        $this->userResponseDtoTransformer = $userResponseDtoTransformer;
        $this->userRepoResponseDtoTransformer = $userRepoResponseDtoTransformer;
    }

    /**
     * Gets initial data for app.
     * @inheritDoc
     */
    public function getUser(string $username): UserResponseDto
    {

        $response = $this->client->request('GET', 'https://api.github.com/users/' . $username);
        $content = $response->getContent();
        $dto = $this->userResponseDtoTransformer->transformFromObject(json_decode($content));

        $responseRepo =  $this->client->request('GET', $dto->repos_url . '?per_page=200');
        $content = $responseRepo->getContent();
        $dtoReposList = $this->userRepoResponseDtoTransformer->transformFromObjects(json_decode($content));
        $dto->repo_list = $dtoReposList;
        $this->calculateLanguagePercentages($dto);

        return $dto;
    }

    /**
     * @param UserResponseDto $dto
     */
    protected function calculateLanguagePercentages(&$dto)
    {

        $languages = [];
        $summary = 0;
        /** @var UserRepoResponseDto $repo */
        foreach ($dto->repo_list as $repo) {
            if (empty($repo->language)) {
                continue;
            }
            if (empty($languages[$repo->language])) {
                $languages[$repo->language] = $repo->size;
            } else {
                $languages[$repo->language] += $repo->size;
            }
            $summary += $repo->size;
        }

        $sizePerOnePercent = $summary/100;
        foreach ($languages as $language => $size) {
            $languageDto = new UserLanguageResponseDto();
            $languageDto->name = $language;
            $languageDto->percentage = round($size/$sizePerOnePercent, 2);
            $dto->language_list[] = $languageDto;
        }
    }
}
