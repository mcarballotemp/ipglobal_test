<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastructure\Controller;

use App\Tests\Functional\BaseFunctional;
use App\Tests\Utilities\Faker;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;

/**
 * @phpstan-type postData array{authorId:int, title:string, body:string}
 * @phpstan-type responseData array{id:int, authorId:int, title:string, body:string}
 */
class PostCreateControllerTest extends BaseFunctional
{
    /**
     * @param postData $post
     */
    #[DataProvider('postProvider')]
    public function test_CreatePost_WithValidData_ReturnCreated($post): void
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

        /** @var responseData */
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
    public function test_CreatePost_WithInvalidData_ReturnCreated($post): void
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
                    'title' => Faker::get()->title(),
                    'body' => Faker::get()->realText(256),
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => Faker::get()->title(),
                    'body' => Faker::get()->realText(256),
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
                    'title' => Faker::get()->title(),
                    'body' => Faker::get()->realText(256),
                ],
            ],
            [
                [
                    'authorId' => 6,
                    'title' => Faker::get()->realText(500),
                    'body' => Faker::get()->realText(256),
                ],
            ],
        ];
    }
}
