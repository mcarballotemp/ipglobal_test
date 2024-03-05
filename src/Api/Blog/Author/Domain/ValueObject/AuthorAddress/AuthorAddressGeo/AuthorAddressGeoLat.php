<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressGeo;

use App\Shared\Domain\ValueObject\FloatValueObject;

class AuthorAddressGeoLat extends FloatValueObject
{
    protected function validate(float $value): void
    {
        parent::validate($value);

        if ($value < -90 || $value > 90) {
            throw new \InvalidArgumentException('Latitude must be between -90 and 90');
        }
    }
}
