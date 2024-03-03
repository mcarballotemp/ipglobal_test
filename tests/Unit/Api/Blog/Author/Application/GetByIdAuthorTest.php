<?php

namespace App\Tests\Unit\Api\Blog\Author\Application;

use App\Api\Blog\Author\Application\DTO\AuthorDTO;
use App\Api\Blog\Author\Application\GetByIdAuthor;
use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GetByIdAuthorTest extends TestCase
{
    #[DataProvider('authorProvider')]
    public function testGetByIdAuthorReturnsAuthor(Author $author): void
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
        return [
            [
                Author::fromPrimitives(
                    1,
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
            ],
        ];
    }
}
