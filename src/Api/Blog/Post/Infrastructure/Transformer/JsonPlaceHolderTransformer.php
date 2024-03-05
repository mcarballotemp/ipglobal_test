<?php

namespace App\Api\Blog\Post\Infrastructure\Transformer;

use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;

/**
 * @phpstan-import-type PostJSonData from \App\Shared\Infrastructure\ApiClient\JsonPlaceHolderApiClient
 */
class JsonPlaceHolderTransformer
{
    /**
     * @param PostJSonData $post
     */
    public function transformToPost($post): Post
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
    public function transformToCollection(array $posts): PostCollection
    {
        return new PostCollection(
            ...array_map(
                fn ($post) => $this->transformToPost($post),
                $posts
            )
        );
    }
}
