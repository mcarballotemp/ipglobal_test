<?php

namespace App\Api\Blog\Domain\Post;

use App\Api\Blog\Domain\Post\ValueObject\PostAuthorId;
use App\Api\Blog\Domain\Post\ValueObject\PostBody;
use App\Api\Blog\Domain\Post\ValueObject\PostId;
use App\Api\Blog\Domain\Post\ValueObject\PostTitle;

class Post
{
    public function __construct(
        public readonly ?PostId $id,
        public readonly PostAuthorId $authorId,
        public readonly PostTitle $title,
        public readonly PostBody $body
    ) {
    }
}
