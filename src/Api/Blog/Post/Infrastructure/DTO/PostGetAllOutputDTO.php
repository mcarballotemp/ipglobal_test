<?php

namespace App\Api\Blog\Post\Infrastructure\DTO;

readonly class PostGetAllOutputDTO
{
    public function __construct(
        public int $id,
        public string $title,
    ) {
    }
}
