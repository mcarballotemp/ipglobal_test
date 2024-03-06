<?php

namespace App\Tests\Functional\Api\Blog\Author\Infrastructure\Controller;

use App\Tests\Functional\BaseFunctional;
use App\Tests\Utilities\Faker;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

class AuthorGetByIdControllerTest extends BaseFunctional
{
    #[DataProvider('authorIdProvider')]
    public function testGetAuthorByIdWithValidDataReturnsAuthorDetails(int $authorId): void
    {
        $this->client->request('GET', '/api/blog/authors/' . $authorId);

        $content = (string) $this->client->getResponse()->getContent();

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content);

        $responseContent = (array) json_decode($content, true);

        $actualKeys = array_keys($responseContent);

        $expectedKeys = $this->getExpectedKeys();

        sort($expectedKeys);
        sort($actualKeys);

        $this->assertEquals($expectedKeys, $actualKeys);
    }

    #[DataProvider('authorWrongsIdProvider')]
    public function testGetAuthorByIdWithInvalidDataReturnsNotFound(int $authorId): void
    {
        $this->client->request('GET', '/api/blog/authors/' . $authorId);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return array<array<int>>
     */
    public static function authorIdProvider(): array
    {
        return array_map(function () {
            return [Faker::get()->numberBetween(1, 9)];
        }, range(1, 2));
    }

    /**
     * @return array<array<int>>
     */
    public static function authorWrongsIdProvider(): array
    {
        return array_map(function () {
            return [Faker::get()->numberBetween(102, 1000)];
        }, range(1, 2));
    }

    /**
     * @return array<string>
     */
    private function getExpectedKeys(): array
    {
        return [
            'id', 'name', 'email', 'address', 'phone', 'website', 'company',
        ];
    }
}
