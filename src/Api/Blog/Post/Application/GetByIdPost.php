<?php

namespace App\Api\Blog\Post\Application;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;

class GetByIdPost
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(int $id): Post
    {
        return $this->repository->find($id);
    }
}
