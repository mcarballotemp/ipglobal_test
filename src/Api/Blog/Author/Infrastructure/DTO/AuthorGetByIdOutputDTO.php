<?php

namespace App\Api\Blog\Author\Infrastructure\DTO;

readonly class AuthorGetByIdOutputDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
