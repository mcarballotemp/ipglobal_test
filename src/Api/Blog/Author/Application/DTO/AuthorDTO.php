<?php

namespace App\Api\Blog\Author\Application\DTO;

readonly class AuthorDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public AuthorAddressDTO $address,
        public string $phone,
        public string $website,
        public AuthorCompanyDTO $company
    ) {
    }
}
