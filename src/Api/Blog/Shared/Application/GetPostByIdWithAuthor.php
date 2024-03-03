<?php

namespace App\Api\Blog\Shared\Application;

use App\Api\Blog\Author\Application\DTO\AuthorDTO;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Shared\Application\DTO\PostWithAuthorDTO;

class GetPostByIdWithAuthor
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly AuthorRepository $authorRepository
    ) {
    }

    public function __invoke(int $id): PostWithAuthorDTO
    {
        $post = $this->postRepository->find($id);
        $author = $this->authorRepository->find($post->authorId->value());

        return new PostWithAuthorDTO(
            $post->id->value(),
            AuthorDTO::createFromAuthor($author),
            $post->title->value(),
            $post->body->value(),
        );
    }
}
