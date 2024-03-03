<?php

namespace App\Api\Blog\Post\Infrastructure\Repository;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @phpstan-type PostsData array<array{id: int, userId: int, title: string, body: string}>
 */
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

    /**
     * @return PostsData
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
     * @param PostsData $posts
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
