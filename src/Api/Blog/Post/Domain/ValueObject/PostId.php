<?php

namespace App\Api\Blog\Post\Domain\ValueObject;

class PostId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->validate($id);
        $this->id = $id;
    }

    public static function create(): self
    {
        return new self(0);
    }

    private function validate(int $id): void
    {
        if ($id < 0) {
            throw new \InvalidArgumentException('PostId must be greater or equal than 0');
        }
    }

    public function value(): int
    {
        return $this->id;
    }
}
