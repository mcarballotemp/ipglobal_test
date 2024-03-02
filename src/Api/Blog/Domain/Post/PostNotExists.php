<?php

namespace App\Api\Blog\Domain\Post;

use RuntimeException;

class PostNotExists extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The Post not exist');
    }
}
