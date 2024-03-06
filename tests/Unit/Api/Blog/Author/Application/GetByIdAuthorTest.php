<?php

namespace App\Tests\Unit\Api\Blog\Author\Application;

use App\Api\Blog\Author\Application\DTO\AuthorDTO;
use App\Api\Blog\Author\Application\GetByIdAuthor;
use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Tests\Factory\AuthorFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetByIdAuthorTest extends TestCase
{
    #[DataProvider('authorProvider')]
    public function testGetByIdAuthorReturnsDTO(Author $author): void
    {
        $authorRepositoryMock = $this->createMock(AuthorRepository::class);
        $authorRepositoryMock->expects($this->once())
            ->method('find')
            ->with($this->equalTo($author->id->value()))
            ->willReturn($author);

        $getByIdAuthor = new GetByIdAuthor($authorRepositoryMock);

        $result = $getByIdAuthor($author->id->value());

        $this->assertInstanceOf(AuthorDTO::class, $result);
        $this->assertEquals($author->name->value(), $result->name);
        $this->assertEquals($author->phone->value(), $result->phone);
    }

    /**
     * @return array<array<Author>>
     */
    public static function authorProvider(): array
    {
        return array_map(function () {
            return [AuthorFactory::createRandom()];
        }, range(1, 5));
    }
}
