<?php

namespace App\Api\Blog\Infrastructure\DTO;

readonly class PostOutputDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $body,
        public int $userId
    ) {
    }
}
