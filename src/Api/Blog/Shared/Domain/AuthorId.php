<?php

namespace App\Api\Blog\Shared\Domain;

use App\Shared\Domain\ValueObject\IntegerValueObject;

class AuthorId extends IntegerValueObject
{
    protected function validate(int $value): void
    {
        parent::validate($value);

        if ($value <= 0) {
            throw new \InvalidArgumentException('PostAuthorId must be greater than 0.');
        }
    }
}
