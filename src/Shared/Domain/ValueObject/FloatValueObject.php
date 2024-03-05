<?php

namespace App\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    protected function validate(float $value): void
    {
        print_r($value);
        if (is_float($value)) {
            throw new \InvalidArgumentException(get_class($this) . ' is not float.');
        }
    }

    public function value(): float
    {
        return $this->value;
    }
}
