<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\CreatePost;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Shared\Domain\AuthorCheckIfExists;
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
    public function testCreatePost($postTestData): void
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

        $this->assertInstanceOf(Post::class, $result);
        $this->assertSame($postCreated, $result);
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
                    'title' => 'titulo corto',
                    'body' => 'body corto',
                    'authorExists' => true,
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => 'titulo algo menos corto',
                    'body' => 'body menos corto',
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
                    'title' => 'titulo corto',
                    'body' => 'body corto',
                    'authorExists' => false,
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, '.
                        'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. '.
                        'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris '.
                        'nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in '.
                        'reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla '.
                        'pariatur. Excepteur sint occaecat cupidatat non proident, sunt in '.
                        'culpa qui officia deserunt mollit anim id est laborum',
                    'body' => 'body menos corto',
                    'authorExists' => false,
                ],
            ],
        ];
    }
}
