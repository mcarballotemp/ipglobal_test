<?php

namespace App\Api\Blog\Post\Infrastructure\Repository;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostNotCreated;
use App\Api\Blog\Post\Domain\PostNotExists;
use App\Api\Blog\Post\Domain\PostRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @phpstan-type PostJSonData array{id: int, userId: int, title: string, body: string}
 */
class JsonPlaceHolderPostRepository implements PostRepository
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrlJsonPlaceholder
    ) {
    }

    public function find(int $id): Post
    {
        return $this->transformToPost($this->fetchPostById($id));
    }

    public function findAll(): PostCollection
    {
        return $this->transformToCollection($this->fetchPosts());
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
     * @return PostJSonData
     */
    private function fetchPostById(int $id): array
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
     * @param PostJSonData $post
     */
    private function transformToPost($post): Post
    {
        return Post::fromPrimitives(
            $post['id'],
            $post['userId'],
            $post['title'],
            $post['body'],
        );
    }

    /**
     * @param array<PostJSonData> $posts
     */
    private function transformToCollection(array $posts): PostCollection
    {
        return new PostCollection(
            ...array_map(
                function ($post) {
                    return Post::fromPrimitives(
                        $post['id'],
                        $post['userId'],
                        $post['title'],
                        $post['body'],
                    );
                },
                $posts
            )
        );
    }
}
