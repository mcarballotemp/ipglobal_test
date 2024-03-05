<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;

class AuthorWebsite extends StringValueObject
{
    protected function validate(string $value): void
    {
        parent::validate($value);

        if (!filter_var($value, FILTER_VALIDATE_DOMAIN)) {
            throw new \InvalidArgumentException('Website URL is invalid.');
        }
    }
}
