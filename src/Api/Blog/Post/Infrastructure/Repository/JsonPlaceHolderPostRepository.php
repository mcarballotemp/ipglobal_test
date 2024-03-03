<?php

namespace App\Api\Blog\Post\Infrastructure\Repository;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Post\Domain\ValueObject\PostBody;
use App\Api\Blog\Post\Domain\ValueObject\PostId;
use App\Api\Blog\Post\Domain\ValueObject\PostTitle;
use App\Api\Blog\Shared\Domain\AuthorId;
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
                        new AuthorId($post['userId']),
                        new PostTitle($post['title']),
                        new PostBody($post['body'])
                    );
                },
                $posts
            )
        );
    }
}
