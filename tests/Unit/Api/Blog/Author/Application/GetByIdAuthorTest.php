<?php

namespace App\Tests\Unit\Api\Blog\Author\Application;

use App\Api\Blog\Author\Application\GetByIdAuthor;
use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use PHPUnit\Framework\TestCase;

class GetByIdAuthorTest extends TestCase
{
    public function testGetByIdAuthorReturnsAuthor(): void
    {
        $authorId = 1;
        
        $authorMock = $this->createMock(Author::class);

        $authorRepositoryMock = $this->createMock(AuthorRepository::class);
        $authorRepositoryMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo($authorId))
            ->willReturn($authorMock);

        $getByIdAuthor = new GetByIdAuthor($authorRepositoryMock);

        $result = $getByIdAuthor($authorId);

        $this->assertInstanceOf(Author::class, $result);
        $this->assertSame($authorMock, $result);
    }
}
