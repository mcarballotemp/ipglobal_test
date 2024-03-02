<?php

namespace App\Api\Blog\Post\Domain;

use App\Api\Blog\Post\Domain\ValueObject\PostAuthorId;
use App\Api\Blog\Post\Domain\ValueObject\PostBody;
use App\Api\Blog\Post\Domain\ValueObject\PostId;
use App\Api\Blog\Post\Domain\ValueObject\PostTitle;

class Post
{
    public function __construct(
        public readonly PostId $id,
        public readonly PostAuthorId $authorId,
        public readonly PostTitle $title,
        public readonly PostBody $body
    ) {
    }
}
