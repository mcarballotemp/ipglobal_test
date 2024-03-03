<?php

namespace App\Tests\Functional\Api\Blog\Author\Infrastrcture\Controller;

use App\Tests\Functional\BaseFunctional;
use Symfony\Component\HttpFoundation\Response;

class AuthorGetByIdControllerTest extends BaseFunctional
{
    public function testGetAuthorById(): void
    {

        $authorId = 1;

        $this->client->request('GET', '/api/blog/author/' . $authorId);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertNotEmpty($response);
        $this->assertJson($this->client->getResponse()->getContent());

        //$this->assertJsonStringEqualsJsonString('', $client->getResponse()->getContent());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
    }
}
