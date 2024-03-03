<?php

namespace App\Api\Blog\Post\Domain;

class PostNotCreated extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The Post could not be created.');
    }
}
