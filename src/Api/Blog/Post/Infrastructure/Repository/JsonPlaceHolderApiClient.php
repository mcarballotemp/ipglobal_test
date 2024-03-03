<?php

namespace App\Api\Blog\Post\Infrastructure\Repository;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostNotCreated;
use App\Api\Blog\Post\Domain\PostNotExists;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @phpstan-import-type PostJSonData from JsonPlaceHolderPostRepository
 */
class JsonPlaceHolderApiClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrlJsonPlaceholder
    ) {
    }

    /**
     * @return PostJSonData
     */
    public function fetchPostById(int $id): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrlJsonPlaceholder.'/posts/'.$id
            );

            if (200 === $response->getStatusCode()) {
                $data = $response->toArray();

                return [
                    'id' => intval($data['id']),
                    'userId' => intval($data['userId']),
                    'title' => $data['title'],
                    'body' => $data['body'],
                ];
            }
        } catch (\Throwable $th) {
        }

        throw new PostNotExists();
    }

    /**
     * @return array<PostJSonData>
     */
    public function fetchPosts(): array
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

    public function savePost(Post $post): int
    {
        try {
            $response = $this->client->request(
                'POST',
                $this->apiUrlJsonPlaceholder.'/posts',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'body' => json_encode(
                        [
                            'title' => $post->title->value(),
                            'body' => $post->body->value(),
                            'userId' => $post->authorId->value(),
                        ]
                    ),
                ]
            );

            if (201 === $response->getStatusCode()) {
                return (int) $response->toArray()['id'];
            }
        } catch (\Throwable $th) {
        }

        throw new PostNotCreated();
    }
}
