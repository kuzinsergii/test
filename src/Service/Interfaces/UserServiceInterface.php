<?php

namespace App\Service\Interfaces;

use App\Dto\Response\UserResponseDto;

interface UserServiceInterface
{
    /**
     * Get data for provided username
     * @param string $username
     *
     * @return UserResponseDto
     */
    public function getUser(string $username): UserResponseDto;
}
