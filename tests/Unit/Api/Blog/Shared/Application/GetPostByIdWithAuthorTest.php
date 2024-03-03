<?php

namespace App\Tests\Unit\Api\Blog\Shared\Application;

use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Shared\Application\DTO\PostWithAuthorDTO;
use App\Api\Blog\Shared\Application\GetPostByIdWithAuthor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetPostByIdWithAuthorTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testGetPostByIdWithAuthor(Post $post, Author $author): void
    {
        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo($post->id->value()))
            ->willReturn($post);

        $authorRepositoryMock = $this->createMock(AuthorRepository::class);
        $authorRepositoryMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo($post->authorId->value()))
            ->willReturn($author);

        $getByIdPost = new GetPostByIdWithAuthor(
            $postRepositoryMock,
            $authorRepositoryMock
        );

        $result = $getByIdPost($post->id->value());

        $this->assertInstanceOf(PostWithAuthorDTO::class, $result);
        $this->assertEquals($post->id->value(), $result->id);
        $this->assertEquals($post->authorId->value(), $result->author->id);
        $this->assertEquals($author->name->value(), $result->author->name);
        $this->assertEquals($author->email->value(), $result->author->email);
        $this->assertEquals($author->phone->value(), $result->author->phone);
        $this->assertEquals($post->title->value(), $result->title);
        $this->assertEquals($post->body->value(), $result->body);
    }

    /**
     * @return array<array{0:Post, 1:Author}>
     */
    public static function dataProvider(): array
    {
        return [[
            Post::fromPrimitives(
                1,
                2,
                'dolorem eum magni eos aperiam quia',
                'dolorem eum magni eos aperiam quiadolorem eum magni eos aperiam quia'
            ),
            Author::fromPrimitives(
                2,
                'Leanne Graham',
                'Sincere@april.biz',
                'Kulas Light',
                'Apt. 556',
                'Gwenborough',
                '92998-3874',
                '-37.3159',
                '81.1496',
                '1-770-736-8031 x56442',
                'hildegard.org',
                'Romaguera-Crona',
                'Multi-layered client-server neural-net',
                'harness real-time e-markets'
            ),
        ]];
    }
}
