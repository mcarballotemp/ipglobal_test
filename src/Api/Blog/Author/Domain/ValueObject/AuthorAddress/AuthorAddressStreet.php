<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress;

class AuthorAddressStreet
{
    private string $street;

    public function __construct(string $street)
    {
        $this->validate($street);
        $this->street = $street;
    }

    private function validate(string $street): void
    {
        if (empty(trim($street))) {
            throw new \InvalidArgumentException('Street cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->street;
    }
}
