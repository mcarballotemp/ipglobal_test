<?php

namespace App\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\DTO\PostDTO;
use App\Api\Blog\Post\Domain\PostRepository;

class GetByIdPost
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(int $id): PostDTO
    {
        $post = $this->repository->find($id);

        return new PostDTO(
            $post->id->value(),
            $post->authorId->value(),
            $post->title->value(),
            $post->body->value(),
        );
    }
}
