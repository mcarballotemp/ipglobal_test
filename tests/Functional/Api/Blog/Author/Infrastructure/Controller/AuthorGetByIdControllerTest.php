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
        $this->client->request('GET', '/api/blog/authors/'.$authorId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $actualKeys = array_keys($responseContent);
        $expectedKeys = $this->getExpectedKeys();

        sort($expectedKeys);
        sort($actualKeys);

        $this->assertEquals($expectedKeys, $actualKeys);
    }

    #[DataProvider('authorWrongsIdProvider')]
    public function testGetAuthorByWrongId(int $authorId): void
    {
        $this->client->request('GET', '/api/blog/authors/'.$authorId);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public static function authorIdProvider(): array
    {
        return [[1], [3], [9]];
    }

    public static function authorWrongsIdProvider(): array
    {
        return [[100]];
    }

    private function getExpectedKeys(): array
    {
        return [
            'id', 'name', 'email', 'address', 'geo', 'phone', 'website', 'company',
        ];
    }
}
