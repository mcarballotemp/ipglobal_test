<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\DTO\PostDTO;
use App\Api\Blog\Post\Application\GetByIdPost;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetByIdPostTest extends TestCase
{
    #[DataProvider('postProvider')]
    public function testGetByIdPostReturnsPost(Post $post): void
    {
        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo($post->id->value()))
            ->willReturn($post);

        $getByIdPost = new GetByIdPost($postRepositoryMock);

        $result = $getByIdPost($post->id->value());

        $this->assertInstanceOf(PostDTO::class, $result);
        $this->assertEquals($post->id->value(), $result->id);
        $this->assertEquals($post->authorId->value(), $result->authorId);
        $this->assertEquals($post->title->value(), $result->title);
        $this->assertEquals($post->body->value(), $result->body);
    }

    /**
     * @return array<array<Post>>
     */
    public static function postProvider(): array
    {
        return [[
            Post::fromPrimitives(
                1,
                2,
                'dolorem eum magni eos aperiam quia',
                'dolorem eum magni eos aperiam quia'
            )
        ]];
    }
}
