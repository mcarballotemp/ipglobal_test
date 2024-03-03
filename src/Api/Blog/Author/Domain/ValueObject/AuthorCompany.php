<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

use App\Api\Blog\Author\Domain\ValueObject\AuthorCompany\AuthorCompanyBs;
use App\Api\Blog\Author\Domain\ValueObject\AuthorCompany\AuthorCompanyCatchPhrase;
use App\Api\Blog\Author\Domain\ValueObject\AuthorCompany\AuthorCompanyName;

class AuthorCompany
{
    private AuthorCompanyName $name;
    private AuthorCompanyCatchPhrase $catchPhrase;
    private AuthorCompanyBs $bs;

    public function __construct(
        AuthorCompanyName $name,
        AuthorCompanyCatchPhrase $catchPhrase,
        AuthorCompanyBs $bs
    ) {
        $this->name = $name;
        $this->catchPhrase = $catchPhrase;
        $this->bs = $bs;
    }

    public function name(): AuthorCompanyName
    {
        return $this->name;
    }

    public function catchPhrase(): AuthorCompanyCatchPhrase
    {
        return $this->catchPhrase;
    }

    public function bs(): AuthorCompanyBs
    {
        return $this->bs;
    }

    public static function fromPrimitives(
        string $name,
        string $catchPhrase,
        string $bs,
    ): self {
        return new self(
            new AuthorCompanyName($name),
            new AuthorCompanyCatchPhrase($catchPhrase),
            new AuthorCompanyBs($bs),
        );
    }
}
