<?php

namespace App\Tests\Unit\Api\Blog\Shared\Application;

use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Shared\Application\DTO\PostWithAuthorDTO;
use App\Api\Blog\Shared\Application\GetPostByIdWithAuthor;
use App\Tests\Factory\AuthorFactory;
use App\Tests\Factory\PostFactory;
use App\Tests\Utilities\Faker;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetPostByIdWithAuthorTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testGetPostByIdWithAuthorReturnsDTO(Post $post, Author $author): void
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
        return array_map(function () {
            $postId = Faker::get()->numberBetween(1, 99);
            $authorId = Faker::get()->numberBetween(1, 99);

            return [
                PostFactory::createRandomWithIDs($postId, $authorId),
                AuthorFactory::createRandomWithID($authorId),
            ];
        }, range(1, 5));
    }
}
