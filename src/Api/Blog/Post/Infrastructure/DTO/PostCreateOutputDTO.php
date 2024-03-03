<?php

namespace App\Api\Blog\Post\Infrastructure\DTO;

readonly class PostCreateOutputDTO
{
    public function __construct(
        public int $id,
    ) {
    }
}
