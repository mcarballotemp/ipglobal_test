<?php

namespace App\Api\Blog\Author\Domain\ValueObject\AuthorAddress;

class AuthorAddressZipCode
{
    private string $zipcode;

    public function __construct(string $zipcode)
    {
        $this->validate($zipcode);
        $this->zipcode = $zipcode;
    }

    private function validate(string $zipcode): void
    {
        if (!preg_match('/^\d{5}(-\d{4})?$/', $zipcode)) {
            throw new \InvalidArgumentException('Zip code is invalid');
        }
    }

    public function value(): string
    {
        return $this->zipcode;
    }
}
