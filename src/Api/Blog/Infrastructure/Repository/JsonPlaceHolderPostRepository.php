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
    public const POST = [
        'car' => 4,
        'bike' => 2,
     ];

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrlJsonPlaceholder
    ) {
    }

    public function findAll(): PostCollection
    {
        return $this->transform($this->fetchPosts());
    }

    /**
     * @return array<array{id: int, userId: int, title: string, body: string}>
     */
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

    /**
     * @param array<array{id: int, userId: int, title: string, body: string}> $posts
     */
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
