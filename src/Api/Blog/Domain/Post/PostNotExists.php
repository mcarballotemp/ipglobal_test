<?php

namespace App\Api\Blog\Domain\Post;

class PostNotExists extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('The Post not exist');
    }
}
