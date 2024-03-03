<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorCompany;

class AuthorCompanyCatchPhrase
{
    private string $catchPhrase;

    public function __construct(string $catchPhrase)
    {
        $this->validate($catchPhrase);
        $this->catchPhrase = $catchPhrase;
    }

    private function validate(string $catchPhrase): void
    {
        if (empty(trim($catchPhrase))) {
            throw new \InvalidArgumentException('Company catch phrase cannot be empty.');
        }
    }

    public function value(): string
    {
        return $this->catchPhrase;
    }
}
