<?php

namespace App\Api\Blog\Post\Domain;

use App\Api\Blog\Post\Domain\ValueObject\PostBody;
use App\Api\Blog\Post\Domain\ValueObject\PostId;
use App\Api\Blog\Post\Domain\ValueObject\PostTitle;
use App\Api\Blog\Shared\Domain\AuthorId;

class Post
{
    public function __construct(
        public readonly PostId $id,
        public readonly AuthorId $authorId,
        public readonly PostTitle $title,
        public readonly PostBody $body
    ) {
    }

    /**
     * @param array{id: int, authorId: int, title: string, body: string} $post
     */
    public static function fromArray(array $post): self
    {
        return new self(
            new PostId($post['id']),
            new AuthorId($post['authorId']),
            new PostTitle($post['title']),
            new PostBody($post['body'])
        );
    }
}
