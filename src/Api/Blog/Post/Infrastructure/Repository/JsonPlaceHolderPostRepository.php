<?php

namespace App\Api\Blog\Post\Infrastructure\Repository;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostNotCreated;
use App\Api\Blog\Post\Domain\PostRepository;
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

    public function create(Post $post): Post
    {
        $savedId = $this->savePost($post);

        return Post::fromPrimitives(
            $savedId,
            $post->authorId->value(),
            $post->title->value(),
            $post->body->value()
        );
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

    private function savePost(Post $post): int
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

    /**
     * @param array<array{id: int, userId: int, title: string, body: string}> $posts
     */
    private function transform(array $posts): PostCollection
    {
        $posts = array_map(function ($post) {
            return [
                'id' => $post['id'],
                'authorId' => $post['userId'],
                'title' => $post['title'],
                'body' => $post['body'],
            ];
        }, $posts);

        return new PostCollection(
            ...array_map(
                function ($post) {
                    return Post::fromArray($post);
                },
                $posts
            )
        );
    }
}
