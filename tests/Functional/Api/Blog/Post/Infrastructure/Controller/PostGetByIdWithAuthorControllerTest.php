<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastructure\Controller;

use App\Tests\Functional\BaseFunctional;
use App\Tests\Utilities\Faker;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

class PostGetByIdWithAuthorControllerTest extends BaseFunctional
{
    #[DataProvider('postIdProvider')]
    public function testGetPostByIdWithAuthorWithValidDataReturnsPostDetails(int $postId): void
    {
        $this->client->request('GET', '/api/blog/posts/' . $postId . '/with/author');

        $content = (string) $this->client->getResponse()->getContent();

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content);

        $responseContent = json_decode($content, true);
        $actualKeys = array_keys((array) $responseContent);
        $expectedKeys = $this->getExpectedKeys();

        sort($expectedKeys);
        sort($actualKeys);

        $this->assertEquals($expectedKeys, $actualKeys);
    }

    #[DataProvider('postWrongsIdProvider')]
    public function testGetPostByIdWithAuthorWithInvalidDataReturnsNotFound(int $postId): void
    {
        $this->client->request('GET', '/api/blog/posts/' . $postId . '/with/author');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return array<array<int>>
     */
    public static function postIdProvider(): array
    {
        return array_map(function () {
            return [Faker::get()->numberBetween(1, 99)];
        }, range(1, 2));
    }

    /**
     * @return array<array<int>>
     */
    public static function postWrongsIdProvider(): array
    {
        return array_map(function () {
            return [Faker::get()->numberBetween(101, 500)];
        }, range(1, 2));
    }

    /**
     * @return array<string>
     */
    private function getExpectedKeys(): array
    {
        return [
            'id', 'author', 'title', 'body',
        ];
    }
}
