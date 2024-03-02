<?php

namespace App\Api\Blog\Infrastructure\Repository;

use App\Api\Blog\Domain\Post\Post;
use App\Api\Blog\Domain\Post\PostCollection;
use App\Api\Blog\Domain\Post\PostRepository;

class JsonPlaceHolderPostRepository implements PostRepository
{
    public function findAll(): PostCollection
    {
        return new PostCollection(new Post('1', 'b', 'c'));
    }
}
