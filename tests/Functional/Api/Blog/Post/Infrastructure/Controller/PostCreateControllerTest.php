<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastrcture\Controller;

use App\Tests\Functional\BaseFunctional;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

class PostCreateControllerTest extends BaseFunctional
{
    #[DataProvider('postProvider')]
    public function testCreatePost($post): void
    {
        $this->client->request(
            'POST',
            '/api/blog/posts',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($post)
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(['id' => 101], $response);
    }

    public static function postProvider(): array
    {
        return [
            [
                [
                    'authorId' => 1,
                    'title' => 'titulo corto',
                    'body' => 'body corto',
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => 'titulo algo menos corto',
                    'body' => 'body menos corto',
                ],
            ],
        ];
    }
}
