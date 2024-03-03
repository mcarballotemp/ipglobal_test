<?php

namespace App\Tests\Functional\Api\Blog\Post\Infrastrcture\Controller;

use App\Tests\Functional\BaseFunctional;
use Symfony\Component\HttpFoundation\Response;

class PostGetAllControllerTest extends BaseFunctional
{
    public function testGetAllPost(): void
    {
        $this->client->request('GET', '/api/blog/posts');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertGreaterThanOrEqual(100, count($responseContent));

        $expectedKeys = $this->getExpectedKeys();

        foreach ($responseContent as $postContent) {
            $actualKeys = array_keys($postContent);
            sort($expectedKeys);
            sort($actualKeys);

            $this->assertEquals($expectedKeys, $actualKeys);
        }
    }

    private function getExpectedKeys(): array
    {
        return [
            'id', 'title',
        ];
    }
}
