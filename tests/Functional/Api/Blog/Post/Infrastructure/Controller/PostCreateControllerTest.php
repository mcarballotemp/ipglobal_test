<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastructure\Controller;

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

        $this->assertEquals('101', $response['id']);
        $this->assertEquals($post['authorId'], $response['authorId']);
        $this->assertEquals($post['title'], $response['title']);
        $this->assertEquals($post['body'], $response['body']);
    }

    /**
     * @param postData $post
     */
    #[DataProvider('postWrongProvider')]
    public function testCreateWrongPost($post): void
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

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
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

    /**
     * @return array<array<postData>>
     */
    public static function postWrongProvider(): array
    {
        return [
            [
                [
                    'authorId' => 100,
                    'title' => 'titulo corto',
                    'body' => 'body corto',
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, ' .
                        'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ' .
                        'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris ' .
                        'nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in ' .
                        'reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla ' .
                        'pariatur. Excepteur sint occaecat cupidatat non proident, sunt in ' .
                        'culpa qui officia deserunt mollit anim id est laborum',
                    'body' => 'body menos corto',
                ],
            ],
        ];
    }
}
