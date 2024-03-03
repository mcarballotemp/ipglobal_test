<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

class AuthorPhone
{
    private string $phone;

    public function __construct(string $phone)
    {
        $this->validate($phone);
        $this->phone = $phone;
    }

    private function validate(string $phone): void
    {
        if (empty(trim($phone))) {
            throw new \InvalidArgumentException('Phone number cannot be empty.');
        }
    }

    public function value(): string
    {
        return $this->phone;
    }
}
