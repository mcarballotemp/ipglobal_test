<?php

namespace App\Api\Blog\Author\Application;

use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;

class GetById
{
    public function __construct(
        private readonly AuthorRepository $repository
    ) {
    }

    public function __invoke(int $id): Author
    {
        return $this->repository->find($id);
    }
}
