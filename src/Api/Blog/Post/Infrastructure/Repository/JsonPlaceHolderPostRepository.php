<?php

namespace App\Api\Blog\Post\Infrastructure\Repository;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;

/**
 * @phpstan-type PostJSonData array{id: int, userId: int, title: string, body: string}
 */
class JsonPlaceHolderPostRepository implements PostRepository
{
    public function __construct(
        private readonly JsonPlaceHolderApiClient $apiClient,
        private readonly JsonPlaceHolderTransformer $transformer,
    ) {
    }

    public function find(int $id): Post
    {
        return $this->transformer->transformToPost(
            $this->apiClient->fetchPostById($id)
        );
    }

    public function findAll(): PostCollection
    {
        return $this->transformer->transformToCollection(
            $this->apiClient->fetchPosts()
        );
    }

    public function create(Post $post): Post
    {
        $savedId = $this->apiClient->savePost($post);

        return Post::fromPrimitives(
            $savedId,
            $post->authorId->value(),
            $post->title->value(),
            $post->body->value()
        );
    }
}
