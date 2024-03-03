<?php

namespace App\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\DTO\PostDTO;
use App\Api\Blog\Post\Domain\PostRepository;

class GetAllPost
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    /**
     * @return array<PostDTO>
     */
    public function __invoke(): array
    {
        $postCollection = $this->repository->findAll();

        return array_map(function ($post) {
            return new PostDTO(
                $post->id->value(),
                $post->authorId->value(),
                $post->title->value(),
                $post->body->value()
            );
        }, $postCollection->getAll());
    }
}
