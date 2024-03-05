<?php

namespace App\Api\Blog\Post\Infrastructure\Repository;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Domain\PostRepository;
use App\Api\Blog\Post\Infrastructure\Transformer\JsonPlaceHolderTransformer;
use App\Shared\Infrastructure\ApiClient\JsonPlaceHolderApiClient;

/**
 * @phpstan-import-type AuthorJsonData from JsonPlaceHolderApiClient
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
        $savedId = $this->apiClient->savePost(
            $post->title->value(),
            $post->body->value(),
            $post->authorId->value()
        );

        return Post::fromPrimitives(
            $savedId,
            $post->authorId->value(),
            $post->title->value(),
            $post->body->value()
        );
    }
}
