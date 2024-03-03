<?php

namespace App\Api\Blog\Post\Application;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Shared\Domain\AuthorCheckIfExists;

class CreatePost
{
    public function __construct(
        private readonly PostRepository $repository,
        private readonly AuthorCheckIfExists $authorCheckIfExists
    ) {
    }

    public function __invoke(
        int $authorID,
        string $title,
        string $body
    ): Post {
        if (!$this->authorCheckIfExists->exists($authorID)) {
            throw new \InvalidArgumentException('Author not exists.');
        }

        return $this->repository->create(
            Post::create(
                $authorID,
                $title,
                $body
            )
        );
    }
}
