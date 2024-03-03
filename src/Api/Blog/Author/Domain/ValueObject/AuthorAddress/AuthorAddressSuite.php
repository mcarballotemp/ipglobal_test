<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress;

class AuthorAddressSuite
{
    private string $suite;

    public function __construct(string $suite)
    {
        $this->validate($suite);
        $this->suite = $suite;
    }

    private function validate(string $suite): void
    {
        if (empty(trim($suite))) {
            throw new \InvalidArgumentException('Suite cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->suite;
    }
}
