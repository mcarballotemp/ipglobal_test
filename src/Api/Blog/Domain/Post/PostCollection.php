<?php

namespace App\Api\Blog\Domain\Post;

class PostCollection
{
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

    public function getAll(): array
    {
        return $this->posts;
    }

    public function count(): int
    {
        return count($this->posts);
    }
}
