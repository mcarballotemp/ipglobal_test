<?php

namespace App\Api\Blog\Application;

use App\Api\Blog\Domain\Post\PostCollection;
use App\Api\Blog\Domain\Post\PostRepository;

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
