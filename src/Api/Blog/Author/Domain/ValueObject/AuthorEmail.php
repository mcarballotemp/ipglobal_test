<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class AuthorEmail extends StringValueObject
{
    protected function validate(string $value): void
    {
        parent::validate($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('AuthorEmail is not valid.');
        }
    }
}
