<?php

namespace App\Api\Blog\Author\Application;

use App\Api\Blog\Author\Application\DTO\AuthorDTO;
use App\Api\Blog\Author\Domain\AuthorRepository;

class GetByIdAuthor
{
    public function __construct(
        private readonly AuthorRepository $repository
    ) {
    }

    public function __invoke(int $id): AuthorDTO
    {
        $author = $this->repository->find($id);

        return AuthorDTO::createFromAuthor($author);
    }
}
