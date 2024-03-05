<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressGeo;

use App\Shared\Domain\ValueObject\FloatValueObject;

class AuthorAddressGeoLng extends FloatValueObject
{
    protected function validate(float $value): void
    {
        parent::validate($value);

        if ($value < -180 || $value > 180) {
            throw new \InvalidArgumentException('Longitude must be between -180 and 180');
        }
    }
}
