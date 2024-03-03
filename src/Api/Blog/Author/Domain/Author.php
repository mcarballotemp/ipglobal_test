<?php

namespace App\Api\Blog\Author\Domain;

use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress;
use App\Api\Blog\Author\Domain\ValueObject\AuthorCompany;
use App\Api\Blog\Author\Domain\ValueObject\AuthorEmail;
use App\Api\Blog\Author\Domain\ValueObject\AuthorName;
use App\Api\Blog\Author\Domain\ValueObject\AuthorPhone;
use App\Api\Blog\Author\Domain\ValueObject\AuthorWebsite;
use App\Api\Blog\Shared\Domain\AuthorId;

class Author
{
    public function __construct(
        public readonly AuthorId $id,
        public readonly AuthorName $name,
        public readonly AuthorEmail $email,
        public readonly AuthorAddress $address,
        public readonly AuthorPhone $phone,
        public readonly AuthorWebsite $website,
        public readonly AuthorCompany $company
    ) {
    }

    /**
     * @param array{
     *   id: int,
     *   name: string,
     *   email: string,
     *   address: array{
     *     street: string,
     *     suite: string,
     *     city: string,
     *     zipcode: string,
     *     geo: array{
     *       lat: string,
     *       lng: string
     *     }
     *   },
     *   phone: string,
     *   company: array{
     *     name: string,
     *     catchPhrase: string,
     *     bs: string
     *   }
     * } $author
     */
    public static function fromArray(array $author): self
    {
        return new self(
            new AuthorId($author['id']),
            new AuthorName($author['name']),
            new AuthorEmail($author['email']),
            AuthorAddress::fromArray($author['address']),
            new AuthorPhone($author['phone']),
            new AuthorWebsite($author['phone']),
            AuthorCompany::fromArray($author['company']),
        );
    }
}
