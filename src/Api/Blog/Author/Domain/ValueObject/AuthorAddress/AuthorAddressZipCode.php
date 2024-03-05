<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress;

use App\Shared\Domain\ValueObject\StringValueObject;

class AuthorAddressZipCode extends StringValueObject
{
    protected function validate(string $zipcode): void
    {
        parent::validate($zipcode);

        if (!preg_match('/^\d{5}(-\d{4})?$/', $zipcode)) {
            throw new \InvalidArgumentException('Zip code is invalid');
        }
    }
}
