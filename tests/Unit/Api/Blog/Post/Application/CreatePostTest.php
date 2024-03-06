<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\CreatePost;
use App\Api\Blog\Post\Application\DTO\PostDTO;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Shared\Domain\AuthorCheckIfExists;
use App\Tests\Factory\PostFactory;
use App\Tests\Utilities\Faker;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CreatePostTest extends TestCase
{
    #[DataProvider('postProvider')]
    public function testCreatePostReturnsDTO(Post $post): void
    {
        $postCreated = $post;

        $postToCreate = Post::create(
            $post->authorId->value(),
            $post->title->value(),
            $post->body->value()
        );

        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($postToCreate))
            ->willReturn($postCreated);

        $AuthorCheckIfExistsMock = $this->createMock(AuthorCheckIfExists::class);
        $AuthorCheckIfExistsMock->expects($this->once())
            ->method('exists')
            ->with($this->equalTo($post->authorId->value()))
            ->willReturn(true);

        $createPost = new CreatePost($postRepositoryMock, $AuthorCheckIfExistsMock);

        $result = $createPost(
            $post->authorId->value(),
            $post->title->value(),
            $post->body->value()
        );

        $this->assertInstanceOf(PostDTO::class, $result);
        $this->assertEquals($postCreated->id->value(), $result->id);
        $this->assertEquals($postCreated->authorId->value(), $result->authorId);
        $this->assertEquals($postCreated->title->value(), $result->title);
        $this->assertEquals($postCreated->body->value(), $result->body);
    }

    public function testCreatePostWithWrongTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Post::fromPrimitives(
            Faker::get()->numberBetween(1, 99),
            Faker::get()->numberBetween(1, 9),
            Faker::get()->realText(5000),
            Faker::get()->realText(500)
        );
    }

    public function testCreatePostWithWrongBody(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Post::fromPrimitives(
            Faker::get()->numberBetween(1, 99),
            Faker::get()->numberBetween(1, 9),
            Faker::get()->title(),
            Faker::get()->realText(5000)
        );
    }

    /**
     * @return array<array<Post>>
     */
    public static function postProvider(): array
    {
        return array_map(function () {
            return [PostFactory::createRandom()];
        }, range(1, 5));
    }
}
