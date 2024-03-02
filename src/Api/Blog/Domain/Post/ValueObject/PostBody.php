<?php

namespace App\Api\Blog\Domain\Post\ValueObject;

class PostBody
{
    private string $body;

    public function __construct(string $body)
    {
        $this->validate($body);
        $this->body = $body;
    }

    private function validate(string $body): void
    {
        if (empty($body)) {
            throw new \InvalidArgumentException("PostBody cannot be empty.");
        }
        if (strlen($body) > 4096) {
            throw new \InvalidArgumentException("PostBody cannot exceed 4096 characters.");
        }
    }

    public function value(): string
    {
        return $this->body;
    }
}