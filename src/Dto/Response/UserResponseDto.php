<?php

namespace App\Dto\Response;

class UserResponseDto
{
    /** @var string */
    public $login;

    /** @var string */
    public $id;

    /** @var string */
    public $url;

    /** @var string */
    public $html_url;

    /** @var string */
    public $repos_url;

    /** @var string */
    public $name;

    /** @var string */
    public $email;

    /** @var string */
    public $blog;

    /** @var string */
    public $public_repos;

    /** @var string */
    public $followers;

    /** @var string */
    public $following;

    /** @var UserRepoResponseDto[] */
    public $repo_list;

    /** @var UserLanguageResponseDto[] */
    public $language_list;

}
