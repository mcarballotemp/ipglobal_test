<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\GetByIdPost;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetByIdPostTest extends TestCase
{
    #[DataProvider('postIdProvider')]
    public function testGetByIdPostReturnsPost(int $postId): void
    {
        $postMock = $this->createMock(Post::class);

        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo($postId))
            ->willReturn($postMock);

        $getByIdPost = new GetByIdPost($postRepositoryMock);

        $result = $getByIdPost($postId);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertSame($postMock, $result);
    }

    /**
     * @return array<array<int>>
     */
    public static function postIdProvider(): array
    {
        return [[1], [333], [9]];
    }
}
