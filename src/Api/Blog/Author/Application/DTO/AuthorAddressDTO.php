<?php

namespace App\Api\Blog\Author\Application\DTO;

readonly class AuthorAddressDTO
{
    public function __construct(
        public string $street,
        public string $suite,
        public string $city,
        public string $zipcode,
        public AuthorAddressGeoDTO $geo,
    ) {
    }
}
