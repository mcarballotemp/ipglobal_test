<?php

namespace App\Api\Blog\Post\Application\DTO;

readonly class PostDTO
{
    public function __construct(
        public int $id,
        public int $authorId,
        public string $title,
        public string $body,
    ) {
    }
}
