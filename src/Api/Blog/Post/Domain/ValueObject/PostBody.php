<?php

namespace App\Api\Blog\Post\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class PostBody extends StringValueObject
{
    protected function validate(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('PostBody cannot be empty.');
        }
        if (strlen($value) > 4096) {
            throw new \InvalidArgumentException('PostBody cannot exceed 4096 characters.');
        }
    }
}
