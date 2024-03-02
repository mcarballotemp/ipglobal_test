<?php

namespace App\Api\Blog\Post\Domain;

class PostCollection
{
    /**
     * @var Post[]
     */
    private array $posts = [];

    public function __construct(Post ...$posts)
    {
        foreach ($posts as $post) {
            $this->add($post);
        }
    }

    public function add(Post $post): void
    {
        $this->posts[] = $post;
    }

    /**
     * @return Post[]
     */
    public function getAll(): array
    {
        return $this->posts;
    }

    public function count(): int
    {
        return count($this->posts);
    }
}
