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

    /**
     * @param array{
     *   name: string,
     *   catchPhrase: string,
     *   bs: string
     * } $company
     */
    public static function fromArray(array $company): self
    {
        return new self(
            new AuthorCompanyName($company['name']),
            new AuthorCompanyCatchPhrase($company['catchPhrase']),
            new AuthorCompanyBs($company['bs']),
        );
    }
}
