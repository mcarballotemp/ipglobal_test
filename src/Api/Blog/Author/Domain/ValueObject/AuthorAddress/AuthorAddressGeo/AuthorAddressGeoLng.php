<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressGeo;

class AuthorAddressGeoLng
{
    private float $lng;

    public function __construct(float $lng)
    {
        $this->validate($lng);
        $this->lng = $lng;
    }

    private function validate(float $lng): void
    {
        if ($lng < -180 || $lng > 180) {
            throw new \InvalidArgumentException('Longitude must be between -180 and 180');
        }
    }

    public function value(): float
    {
        return $this->lng;
    }
}
