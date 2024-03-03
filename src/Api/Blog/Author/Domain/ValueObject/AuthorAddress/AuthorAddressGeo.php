<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress;

use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressGeo\AuthorAddressGeoLat;
use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressGeo\AuthorAddressGeoLng;

class AuthorAddressGeo
{
    private AuthorAddressGeoLat $lat;
    private AuthorAddressGeoLng $lng;

    public function __construct(
        AuthorAddressGeoLat $lat,
        AuthorAddressGeoLng $lng
    ) {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function lat(): AuthorAddressGeoLat
    {
        return $this->lat;
    }

    public function lng(): AuthorAddressGeoLng
    {
        return $this->lng;
    }

    /**
     * @param array{
     *   lat: string,
     *   lng: string
     * } $geo
     */
    public static function fromArray(array $geo): self
    {
        return new self(
            new AuthorAddressGeoLat(floatval($geo['lat'])),
            new AuthorAddressGeoLng(floatval($geo['lng']))
        );
    }
}
