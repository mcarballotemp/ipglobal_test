<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorCompany;

class AuthorCompanyBs
{
    private string $bs;

    public function __construct(string $bs)
    {
        $this->validate($bs);
        $this->bs = $bs;
    }

    private function validate(string $bs): void
    {
        if (empty(trim($bs))) {
            throw new \InvalidArgumentException('Company bs cannot be empty.');
        }
    }

    public function value(): string
    {
        return $this->bs;
    }
}
