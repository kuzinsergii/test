<?php

namespace App\Dto\Response\Transformer;

use App\Dto\Response\UserResponseDto;

class UserResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param object $user
     *
     * @return UserResponseDto $user
     */
    public function transformFromObject($user): UserResponseDto
    {
        $dto = new UserResponseDto();
        $dto->name = $user->name;
        $dto->repos_url = $user->repos_url;
        $dto->html_url = $user->html_url;
        $dto->blog = $user->blog;
        $dto->public_repos = $user->public_repos;
        $dto->followers = $user->followers;
        $dto->following = $user->following;

        return $dto;
    }

}
