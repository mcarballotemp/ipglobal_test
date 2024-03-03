<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

class AuthorEmail
{
    private string $email;

    public function __construct(string $email)
    {
        $this->validate($email);
        $this->email = $email;
    }

    private function validate(string $email): void
    {
        if (empty(trim($email))) {
            throw new \InvalidArgumentException('AuthorEmail cannot be empty.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('AuthorEmail is not valid.');
        }
    }

    public function value(): string
    {
        return $this->email;
    }
}
