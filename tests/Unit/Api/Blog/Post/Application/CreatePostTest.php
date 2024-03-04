<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\CreatePost;
use App\Api\Blog\Post\Application\DTO\PostDTO;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Shared\Domain\AuthorCheckIfExists;
use App\Tests\Utilities\Faker;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @phpstan-type postData array{authorId:int, title:string, body:string, authorExists:bool}
 */
class CreatePostTest extends TestCase
{
    /**
     * @param postData $postTestData
     */
    #[DataProvider('postProvider')]
    public function test_CreatePost_ReturnsDTO($postTestData): void
    {
        $postCreated = Post::fromPrimitives(
            101,
            $postTestData['authorId'],
            $postTestData['title'],
            $postTestData['body']
        );

        $postToCreate = Post::create(
            $postTestData['authorId'],
            $postTestData['title'],
            $postTestData['body']
        );

        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($postToCreate))
            ->willReturn($postCreated);

        $AuthorCheckIfExistsMock = $this->createMock(AuthorCheckIfExists::class);
        $AuthorCheckIfExistsMock->expects($this->once())
            ->method('exists')
            ->with($this->equalTo($postTestData['authorId']))
            ->willReturn($postTestData['authorExists']);

        $createPost = new CreatePost($postRepositoryMock, $AuthorCheckIfExistsMock);

        $result = $createPost(
            $postTestData['authorId'],
            $postTestData['title'],
            $postTestData['body']
        );

        $this->assertInstanceOf(PostDTO::class, $result);
        $this->assertEquals($postCreated->id->value(), $result->id);
        $this->assertEquals($postCreated->authorId->value(), $result->authorId);
        $this->assertEquals($postCreated->title->value(), $result->title);
        $this->assertEquals($postCreated->body->value(), $result->body);
    }

    /**
     * @param postData $postTestData
     */
    #[DataProvider('postWrongProvider')]
    public function testCreateWrongPost($postTestData): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $postRepositoryMock = $this->createMock(PostRepository::class);

        $AuthorCheckIfExistsMock = $this->createMock(AuthorCheckIfExists::class);
        $AuthorCheckIfExistsMock->expects($this->once())
            ->method('exists')
            ->with($this->equalTo($postTestData['authorId']))
            ->willReturn($postTestData['authorExists']);

        $createPost = new CreatePost($postRepositoryMock, $AuthorCheckIfExistsMock);

        $createPost(
            $postTestData['authorId'],
            $postTestData['title'],
            $postTestData['body']
        );
    }

    /**
     * @return array<array<postData>>
     */
    public static function postProvider(): array
    {
        return [
            [
                [
                    'authorId' => 1,
                    'title' => Faker::get()->title(),
                    'body' => Faker::get()->realText(200),
                    'authorExists' => true,
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => Faker::get()->title(),
                    'body' => Faker::get()->realText(300),
                    'authorExists' => true,
                ],
            ],
        ];
    }

    /**
     * @return array<array<postData>>
     */
    public static function postWrongProvider(): array
    {
        return [
            [
                [
                    'authorId' => 100,
                    'title' => Faker::get()->title(),
                    'body' => Faker::get()->realText(500),
                    'authorExists' => false,
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => Faker::get()->realText(1000),
                    'body' => Faker::get()->realText(200),
                    'authorExists' => false,
                ],
            ],
        ];
    }
}
