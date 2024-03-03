<?php

namespace App\Api\Blog\Author\Domain;

class AuthorNotExists extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The Author not exist');
    }
}
