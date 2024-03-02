<?php

namespace App\Api\Blog\Post\Application;

use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;

class GetAllPost
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(): PostCollection
    {
        return $this->repository->findAll();
    }
}
