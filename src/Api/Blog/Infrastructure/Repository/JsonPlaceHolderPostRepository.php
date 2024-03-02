<?php

namespace App\Api\Blog\Infrastructure\Repository;

use App\Api\Blog\Domain\Post\Post;
use App\Api\Blog\Domain\Post\PostCollection;
use App\Api\Blog\Domain\Post\PostRepository;
use App\Api\Blog\Domain\Post\ValueObject\PostAuthorId;
use App\Api\Blog\Domain\Post\ValueObject\PostBody;
use App\Api\Blog\Domain\Post\ValueObject\PostId;
use App\Api\Blog\Domain\Post\ValueObject\PostTitle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class JsonPlaceHolderPostRepository implements PostRepository
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrlJsonPlaceholder
    ) {
    }

    public function findAll(): PostCollection
    {
        return $this->transform($this->fetchPosts());
    }

    private function fetchPosts(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrlJsonPlaceholder.'/posts'
            );

            if (200 === $response->getStatusCode()) {
                return $response->toArray();
            }
        } catch (\Throwable $th) {
        }

        return [];
    }

    private function transform(array $posts): PostCollection
    {
        return new PostCollection(
            ...array_map(
                function ($post) {
                    return new Post(
                        new PostId($post['id']),
                        new PostAuthorId($post['userId']),
                        new PostTitle($post['title']),
                        new PostBody($post['body'])
                    );
                },
                $posts
            )
        );
    }
}
