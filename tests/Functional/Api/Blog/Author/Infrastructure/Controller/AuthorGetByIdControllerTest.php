<?php

namespace App\Tests\Functional\Api\Blog\Author\Infrastrcture\Controller;

use App\Tests\Functional\BaseFunctional;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

class AuthorGetByIdControllerTest extends BaseFunctional
{
    #[DataProvider('authorIdProvider')]
    public function testGetAuthorById(int $authorId): void
    {
        $this->client->request('GET', '/api/blog/author/' . $authorId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertNotEmpty($response);
        $this->assertJson($this->client->getResponse()->getContent());
    }

    #[DataProvider('authorWrongsIdProvider')]
    public function testGetAuthorByWrongId(int $authorId): void
    {
        $this->client->request('GET', '/api/blog/author/' . $authorId);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public static function authorIdProvider(): array
    {
        return [[1], [3], [9]];
    }

    public static function authorWrongsIdProvider(): array
    {
        return [[100], [300], [30]];
    }
}
