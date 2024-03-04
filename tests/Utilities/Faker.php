<?php

namespace App\Tests\Utilities;

class Faker
{
    public static function get(): \Faker\Generator
    {
        return \Faker\Factory::create();
    }
}
