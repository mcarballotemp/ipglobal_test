<?php

namespace App\Tests\Factory;

use App\Api\Blog\Author\Domain\Author;
use App\Tests\Utilities\Faker;

class AuthorFactory
{
    public static function createRandom(): Author
    {
        return Author::fromPrimitives(
            Faker::get()->numberBetween(1, 9),
            Faker::get()->title(),
            Faker::get()->email(),
            Faker::get()->streetAddress(),
            Faker::get()->streetAddress(),
            Faker::get()->city(),
            Faker::get()->postcode(),
            (string) Faker::get()->latitude(-90, 90),
            (string) Faker::get()->longitude(-180, 180),
            Faker::get()->phoneNumber(),
            Faker::get()->domainName(),
            Faker::get()->title(),
            Faker::get()->realText(30),
            Faker::get()->realText(30)
        );
    }

    public static function createRandomWithID(int $id): Author
    {
        return Author::fromPrimitives(
            $id,
            Faker::get()->title(),
            Faker::get()->email(),
            Faker::get()->streetAddress(),
            Faker::get()->streetAddress(),
            Faker::get()->city(),
            Faker::get()->postcode(),
            (string) Faker::get()->latitude(-90, 90),
            (string) Faker::get()->longitude(-180, 180),
            Faker::get()->phoneNumber(),
            Faker::get()->domainName(),
            Faker::get()->title(),
            Faker::get()->realText(30),
            Faker::get()->realText(30)
        );
    }
}
