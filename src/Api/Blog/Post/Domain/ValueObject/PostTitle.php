<?php

namespace App\Api\Blog\Post\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class PostTitle extends StringValueObject
{
    protected function validate(string $value): void
    {
        parent::validate($value);

        if (empty($value)) {
            throw new \InvalidArgumentException('PostTitle cannot be empty.');
        }
        if (strlen($value) > 2156) {
            throw new \InvalidArgumentException('PostTitle cannot exceed 256 characters.');
        }
    }
}
