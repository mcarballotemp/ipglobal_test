<?php

namespace App\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    protected function validate(string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException(get_class($this).' cannot be empty.');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}
