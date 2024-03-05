<?php

namespace App\Api\Blog\Post\Domain\ValueObject;

use App\Shared\Domain\ValueObject\IntegerValueObject;

class PostId extends IntegerValueObject
{
    public static function create(): self
    {
        return new self(0);
    }

    protected function validate(int $value): void
    {
        parent::validate($value);

        if ($value < 0) {
            throw new \InvalidArgumentException('PostId must be greater or equal than 0');
        }
    }
}
