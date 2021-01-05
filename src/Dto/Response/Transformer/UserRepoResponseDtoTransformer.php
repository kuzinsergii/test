<?php

namespace App\Dto\Response\Transformer;

use App\Dto\Response\UserRepoResponseDto;
use App\Dto\Response\UserResponseDto;

class UserRepoResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param object $userRepo
     *
     * @return UserRepoResponseDto $userRepo
     */
    public function transformFromObject($userRepo): UserRepoResponseDto
    {
        $dto = new UserRepoResponseDto();
        $dto->name = $userRepo->name;
        $dto->description = $userRepo->description;
        $dto->link = $userRepo->html_url;
        $dto->language = $userRepo->language;
        $dto->size = $userRepo->size;

        return $dto;
    }


}
