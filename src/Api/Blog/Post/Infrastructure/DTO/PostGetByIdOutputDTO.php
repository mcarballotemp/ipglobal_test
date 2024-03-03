<?php

namespace App\Api\Blog\Post\Infrastructure\DTO;

readonly class PostGetByIdOutputDTO
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $title,
        public string $body,
    ) {
    }
}
