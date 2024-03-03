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

    public static function fromPrimitives(
        int $id,
        string $name,
        string $email,
        string $addressStreet,
        string $addressSuite,
        string $addressCity,
        string $addressZipcode,
        string $addressGeoLat,
        string $addressGeoLng,
        string $phone,
        string $website,
        string $companyName,
        string $companyCatchPhrase,
        string $companyBs,
    ): self {
        return new self(
            new AuthorId($id),
            new AuthorName($name),
            new AuthorEmail($email),
            AuthorAddress::fromPrimitives(
                $addressStreet,
                $addressSuite,
                $addressCity,
                $addressZipcode,
                $addressGeoLat,
                $addressGeoLng,
            ),
            new AuthorPhone($phone),
            new AuthorWebsite($website),
            AuthorCompany::fromPrimitives(
                $companyName,
                $companyCatchPhrase,
                $companyBs,
            ),
        );
    }
}
