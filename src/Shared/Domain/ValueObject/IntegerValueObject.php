<?php

namespace App\Shared\Domain\ValueObject;

abstract class IntegerValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    protected function validate(int $value): void
    {
        if (!is_int($value)) {
            throw new \InvalidArgumentException(get_class($this).' is not integer.');
        }
    }

    public function value(): int
    {
        return $this->value;
    }
}
