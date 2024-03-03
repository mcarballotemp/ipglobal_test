<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress;

class AuthorAddressCity
{
    private string $city;

    public function __construct(string $city)
    {
        $this->validate($city);
        $this->city = $city;
    }

    private function validate(string $city): void
    {
        if (empty(trim($city))) {
            throw new \InvalidArgumentException('City cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->city;
    }
}
