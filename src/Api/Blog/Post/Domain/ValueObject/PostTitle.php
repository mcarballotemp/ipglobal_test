<?php

namespace App\Api\Blog\Post\Domain\ValueObject;

class PostTitle
{
    private string $title;

    public function __construct(string $title)
    {
        $this->validate($title);
        $this->title = $title;
    }

    private function validate(string $title): void
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('PostTitle cannot be empty.');
        }
        if (strlen($title) > 2156) {
            throw new \InvalidArgumentException('PostTitle cannot exceed 256 characters.');
        }
    }

    public function value(): string
    {
        return $this->title;
    }
}
