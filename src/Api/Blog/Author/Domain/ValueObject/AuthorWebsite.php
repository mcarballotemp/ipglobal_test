<?php

namespace App\Api\Blog\Author\Domain\ValueObject;

class AuthorWebsite
{
    private string $website;

    public function __construct(string $website)
    {
        $this->validate($website);
        $this->website = $website;
    }

    private function validate(string $website): void
    {
        if (!filter_var($website, FILTER_VALIDATE_DOMAIN)) {
            throw new \InvalidArgumentException('Website URL is invalid.');
        }
    }

    public function value(): string
    {
        return $this->website;
    }
}
