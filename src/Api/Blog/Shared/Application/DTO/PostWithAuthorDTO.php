<?php

namespace App\Api\Blog\Shared\Application\DTO;

use App\Api\Blog\Author\Application\DTO\AuthorDTO;

readonly class PostWithAuthorDTO
{
    public function __construct(
        public int $id,
        public AuthorDTO $author,
        public string $title,
        public string $body,
    ) {
    }
}
