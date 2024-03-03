<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressCity;
use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressGeo;
use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressStreet;
use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressSuite;
use App\Api\Blog\Author\Domain\ValueObject\AuthorAddress\AuthorAddressZipCode;

class AuthorAddress
{
    private AuthorAddressStreet $street;
    private AuthorAddressSuite $suite;
    private AuthorAddressCity $city;
    private AuthorAddressZipCode $zipcode;
    private AuthorAddressGeo $geo;

    public function __construct(
        AuthorAddressStreet $street,
        AuthorAddressSuite $suite,
        AuthorAddressCity $city,
        AuthorAddressZipCode $zipcode,
        AuthorAddressGeo $geo
    ) {
        $this->street = $street;
        $this->suite = $suite;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->geo = $geo;
    }

    public function street(): AuthorAddressStreet
    {
        return $this->street;
    }

    public function suite(): AuthorAddressSuite
    {
        return $this->suite;
    }

    public function city(): AuthorAddressCity
    {
        return $this->city;
    }

    public function zipcode(): AuthorAddressZipCode
    {
        return $this->zipcode;
    }

    public function geo(): AuthorAddressGeo
    {
        return $this->geo;
    }

    /**
     * @param array{
     *   street: string,
     *   suite: string,
     *   city: string,
     *   zipcode: string,
     *   geo: array{
     *     lat: string,
     *     lng: string,
     *   }
     * } $address
     */
    public static function fromArray(array $address): self
    {
        return new self(
            new AuthorAddressStreet($address['street']),
            new AuthorAddressSuite($address['suite']),
            new AuthorAddressCity($address['city']),
            new AuthorAddressZipCode($address['zipcode']),
            AuthorAddressGeo::fromArray($address['geo']),
        );
    }
}
