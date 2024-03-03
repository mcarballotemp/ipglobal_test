<?php

namespace App\Api\Blog\Author\Application\DTO;

readonly class AuthorCompanyDTO
{
    public function __construct(
        public string $name,
        public string $catchPhrase,
        public string $bs
    ) {
    }
}
