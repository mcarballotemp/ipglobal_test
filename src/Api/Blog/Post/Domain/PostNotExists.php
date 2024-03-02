<?php

namespace App\Api\Blog\Post\Domain;

class PostNotExists extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The Post not exist');
    }
}
