<?php

namespace App\Tests\Unit\Api\Blog\Author\Application;

use App\Api\Blog\Author\Application\DTO\AuthorDTO;
use App\Api\Blog\Author\Application\GetByIdAuthor;
use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Tests\Utilities\Faker;
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
        return [
            [
                Author::fromPrimitives(
                    3,
                    Faker::get()->title(),
                    Faker::get()->email(),
                    Faker::get()->streetAddress(),
                    Faker::get()->streetAddress(),
                    Faker::get()->city(),
                    Faker::get()->postcode(),
                    (string) Faker::get()->latitude(-90, 90),
                    (string) Faker::get()->longitude(-180, 180),
                    Faker::get()->phoneNumber(),
                    Faker::get()->domainName(),
                    Faker::get()->title(),
                    Faker::get()->realText(30),
                    Faker::get()->realText(30)
                ),
            ],
        ];
    }
}
