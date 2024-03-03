<?php

namespace App\Api\Blog\Post\Domain;

interface PostRepository
{
    public function find(int $id): Post;

    public function findAll(): PostCollection;

    public function create(Post $post): Post;
}
