<?php

namespace App\Tests\Unit\Api\Blog\Post\Application;

use App\Api\Blog\Post\Application\GetAllPost;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;
use PHPUnit\Framework\TestCase;

class GetAllPostTest extends TestCase
{
    public function testGetAllPost(): void
    {
        $postCollectionMock = $this->createMock(PostCollection::class);

        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($postCollectionMock);

        $getAllPost = new GetAllPost($postRepositoryMock);

        $result = $getAllPost();

        $this->assertInstanceOf(PostCollection::class, $result);
        $this->assertSame($postCollectionMock, $result);
    }
}
