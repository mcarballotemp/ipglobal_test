<?php

namespace App\Api\Blog\Shared\Domain;

class AuthorId
{
    private int $authorId;

    public function __construct(int $authorId)
    {
        $this->validate($authorId);
        $this->authorId = $authorId;
    }

    private function validate(int $authorId): void
    {
        if ($authorId <= 0) {
            throw new \InvalidArgumentException('PostAuthorId must be greater than 0.');
        }
    }

    public function value(): int
    {
        return $this->authorId;
    }
}
