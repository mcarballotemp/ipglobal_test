<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastrcture\Controller;

use App\Tests\Functional\BaseFunctional;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

class PostGetByIdControllerTest extends BaseFunctional
{
    #[DataProvider('postIdProvider')]
    public function testGetPostById(int $postId): void
    {
        $this->client->request('GET', '/api/blog/posts/'.$postId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $actualKeys = array_keys($responseContent);
        $expectedKeys = $this->getExpectedKeys();

        sort($expectedKeys);
        sort($actualKeys);

        $this->assertEquals($expectedKeys, $actualKeys);
    }

    #[DataProvider('postWrongsIdProvider')]
    public function testGetPostByWrongId(int $postId): void
    {
        $this->client->request('GET', '/api/blog/posts/'.$postId);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public static function postIdProvider(): array
    {
        return [[1], [33], [99]];
    }

    public static function postWrongsIdProvider(): array
    {
        return [[300]];
    }

    private function getExpectedKeys(): array
    {
        return [
            'id', 'userId', 'title', 'body',
        ];
    }
}