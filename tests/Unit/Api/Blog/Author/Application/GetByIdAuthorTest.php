<?php

namespace App\Tests\Unit\Api\Blog\Author\Application;

use App\Api\Blog\Author\Application\GetByIdAuthor;
use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetByIdAuthorTest extends TestCase
{
    #[DataProvider('authorIdProvider')]
    public function testGetByIdAuthorReturnsAuthor(int $authorId): void
    {
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

    /**
     * @return array<array<int>>
     */
    public static function authorIdProvider(): array
    {
        return [[1], [3], [999]];
    }
}
