<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\GetAllPost;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @phpstan-type postData array{id:int, authorId:int, title:string, body:string}
 */
class GetAllPostTest extends TestCase
{
    /**
     * @param postData $postTestData
     */
    #[DataProvider('postProvider')]
    public function testGetAllPost($postTestData): void
    {
        $post = Post::fromPrimitives(
            $postTestData['id'],
            $postTestData['authorId'],
            $postTestData['title'],
            $postTestData['body'],
        );

        $postCollection = new PostCollection();
        $postCollection->add($post);

        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($postCollection);

        $getAllPost = new GetAllPost($postRepositoryMock);

        $result = $getAllPost();

        $this->assertIsArray($result);
        foreach ($result as $postResult) {
            $this->assertEquals($post->id->value(), $postResult->id);
            $this->assertEquals($post->authorId->value(), $postResult->authorId);
            $this->assertEquals($post->title->value(), $postResult->title);
            $this->assertEquals($post->body->value(), $postResult->body);
        }
    }

    /**
     * @return array<array<postData>>
     */
    public static function postProvider(): array
    {
        return [
            [
                [
                    'id' => 1,
                    'authorId' => 1,
                    'title' => 'titulo corto',
                    'body' => 'body corto',
                ],
            ],
            [
                [
                    'id' => 2,
                    'authorId' => 6,
                    'title' => 'titulo algo menos corto',
                    'body' => 'body menos corto',
                ],
            ],
        ];
    }
}
