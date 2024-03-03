<?php

namespace App\Api\Blog\Author\Domain;

interface AuthorRepository
{
    public function find(int $id): Author;
}
