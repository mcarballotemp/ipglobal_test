<?php

namespace App\Api\Blog\Shared\Domain;

interface AuthorCheckIfExists
{
    public function exists(int $id): bool;
}
