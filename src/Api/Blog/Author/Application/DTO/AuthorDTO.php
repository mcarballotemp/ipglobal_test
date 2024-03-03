<?php

namespace App\Api\Blog\Author\Application\DTO;

use App\Api\Blog\Author\Domain\Author;

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

    public static function createFromAuthor(Author $author): self
    {
        return new AuthorDTO(
            $author->id->value(),
            $author->name->value(),
            $author->email->value(),
            new AuthorAddressDTO(
                $author->address->street()->value(),
                $author->address->suite()->value(),
                $author->address->city()->value(),
                $author->address->zipcode()->value(),
                new AuthorAddressGeoDTO(
                    strval($author->address->geo()->lat()->value()),
                    strval($author->address->geo()->lat()->value()),
                )
            ),
            $author->phone->value(),
            $author->website->value(),
            new AuthorCompanyDTO(
                $author->company->name()->value(),
                $author->company->catchPhrase()->value(),
                $author->company->bs()->value(),
            )
        );
    }
}
