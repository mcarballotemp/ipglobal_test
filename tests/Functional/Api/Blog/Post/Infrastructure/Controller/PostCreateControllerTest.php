<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastrcture\Controller;

use App\Tests\Functional\BaseFunctional;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

/**
 * @phpstan-type postData array{authorId:int, title:string, body:string}
 */
class PostCreateControllerTest extends BaseFunctional
{
    /**
     * @param postData $post
     */
    #[DataProvider('postProvider')]
    public function testCreatePost($post): void
    {
        $this->client->request(
            'POST',
            '/api/blog/posts',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            (string) json_encode($post)
        );

        $content = (string) $this->client->getResponse()->getContent();

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        $this->assertJson($content);

        $response = json_decode($content, true);
        $this->assertEquals(['id' => 101], $response);
    }

    /**
     * @return array<array<postData>>
     */
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
