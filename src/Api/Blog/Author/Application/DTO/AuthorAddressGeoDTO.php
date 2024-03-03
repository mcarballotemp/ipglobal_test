<?php

namespace App\Api\Blog\Author\Application\DTO;

readonly class AuthorAddressGeoDTO
{
    public function __construct(
        public string $lat,
        public string $lng,
    ) {
    }
}
