<?php

namespace App\Api\Blog\Author\Infrastructure\DTO;

use App\Api\Blog\Author\Domain\Author;

readonly class AuthorGetByIdOutputDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $address,
        public string $geo,
        public string $phone,
        public string $website,
        public string $company
    ) {
    }

    public static function fromAuthor(Author $author): self
    {
        return new self(
            $author->id->value(),
            $author->name->value(),
            $author->email->value(),
            $author->address->street()->value() . ', ' .
                $author->address->suite()->value() . ', ' .
                $author->address->zipcode()->value(),
            $author->address->geo()->lat()->value() . ', ' .
                $author->address->geo()->lng()->value(),
            $author->phone->value(),
            $author->website->value(),
            $author->company->name()->value(),
        );
    }
}
