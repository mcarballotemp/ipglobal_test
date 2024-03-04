<?php

namespace App\Tests\Utilities;

class Faker
{
    private static ?\Faker\Generator $faker = null;

    public static function get(): \Faker\Generator
    {
        if (null === self::$faker) {
            self::$faker = \Faker\Factory::create();
        }

        return self::$faker;
    }
}
