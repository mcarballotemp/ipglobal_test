<?php

namespace App\Tests\Factory;

use App\Api\Blog\Post\Domain\Post;
use App\Tests\Utilities\Faker;

class PostFactory
{
    public static function createRandom(): Post
    {
        return Post::fromPrimitives(
            Faker::get()->numberBetween(1, 99),
            Faker::get()->numberBetween(1, 9),
            Faker::get()->title(),
            Faker::get()->realText(500)
        );
    }

    public static function createRandomWithIDs(int $id, int $authorId): Post
    {
        return Post::fromPrimitives(
            $id,
            $authorId,
            Faker::get()->title(),
            Faker::get()->realText(500)
        );
    }
}
