<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

class AuthorName
{
    private string $name;

    public function __construct(string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    private function validate(string $name): void
    {
        if (empty(trim($name))) {
            throw new \InvalidArgumentException('AuthorName cannot be empty.');
        }
    }

    public function value(): string
    {
        return $this->name;
    }
}
