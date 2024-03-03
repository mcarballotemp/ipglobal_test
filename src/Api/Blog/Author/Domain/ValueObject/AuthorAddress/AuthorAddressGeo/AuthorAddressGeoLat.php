<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressGeo;

class AuthorAddressGeoLat
{
    private float $lat;

    public function __construct(float $lat)
    {
        $this->validate($lat);
        $this->lat = $lat;
    }

    private function validate(float $lat): void
    {
        if ($lat < -90 || $lat > 90) {
            throw new \InvalidArgumentException('Latitude must be between -90 and 90');
        }
    }

    public function value(): float
    {
        return $this->lat;
    }
}
