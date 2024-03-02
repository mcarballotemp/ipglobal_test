<?php

namespace App\Api\Blog\Domain\Post\ValueObject;

class PostId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->validate($id);
        $this->id = $id;
    }

    private function validate(int $id): void
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('PostId must be greater than 0.');
        }
    }

    public function value(): int
    {
        return $this->id;
    }
}
