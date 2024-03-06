<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\GetAllPost;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Tests\Unit\Api\Blog\Shared\Factory\PostFactory;
use App\Tests\Utilities\Faker;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetAllPostTest extends TestCase
{
    /**
     * @param array<Post> $posts
     */
    #[DataProvider('postProvider')]
    public function test_GetAllPost_ReturnsArrayDTO($posts): void
    {
        $postCollection = new PostCollection();
        $postCollection->add(...$posts);

        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($postCollection);

        $getAllPost = new GetAllPost($postRepositoryMock);

        $result = $getAllPost();

        $this->assertIsArray($result);
        foreach ($result as $key => $postResult) {
            $this->assertEquals($posts[$key]->id->value(), $postResult->id);
            $this->assertEquals($posts[$key]->authorId->value(), $postResult->authorId);
            $this->assertEquals($posts[$key]->title->value(), $postResult->title);
            $this->assertEquals($posts[$key]->body->value(), $postResult->body);
        }
    }

    /**
     * @return array<int, array<int, array<int, Post>>>
     */
    public static function postProvider(): array
    {
        $posts = [];
        for ($i = 0; $i < 5; $i++) {
            $posts[] = [
                [
                    PostFactory::createRandom(),
                    PostFactory::createRandom(),
                ],
                [
                    PostFactory::createRandom(),
                    PostFactory::createRandom(),
                ],
            ];
        }
        return $posts;
    }
}
