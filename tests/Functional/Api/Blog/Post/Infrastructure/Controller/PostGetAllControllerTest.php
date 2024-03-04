<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastructure\Controller;

use App\Tests\Functional\BaseFunctional;
use Symfony\Component\HttpFoundation\Response;

class PostGetAllControllerTest extends BaseFunctional
{
    public function testGetAllPostReturnsAllPost(): void
    {
        $this->client->request('GET', '/api/blog/posts');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $content = (string) $this->client->getResponse()->getContent();

        $this->assertJson($content);

        $responseContent = (array) json_decode($content, true);

        $this->assertGreaterThanOrEqual(100, count($responseContent));

        $expectedKeys = $this->getExpectedKeys();

        foreach ($responseContent as $postContent) {
            $actualKeys = array_keys((array) $postContent);
            sort($expectedKeys);
            sort($actualKeys);

            $this->assertEquals($expectedKeys, $actualKeys);
        }
    }

    /**
     * @return array<string>
     */
    private function getExpectedKeys(): array
    {
        return [
            'id', 'authorId', 'title', 'body',
        ];
    }
}
