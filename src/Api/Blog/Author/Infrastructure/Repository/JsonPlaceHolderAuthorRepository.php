<?php

namespace App\Api\Blog\Author\Infrastructure\Repository;

use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Api\Blog\Author\Infrastructure\Transformer\JsonPlaceHolderAuthorTransformer;
use App\Api\Blog\Shared\Domain\AuthorCheckIfExists;
use App\Shared\Infrastructure\ApiClient\JsonPlaceHolderApiClient;

/**
 * @phpstan-import-type AuthorJsonData from JsonPlaceHolderApiClient
 */
class JsonPlaceHolderAuthorRepository implements AuthorRepository, AuthorCheckIfExists
{
    public function __construct(
        private readonly JsonPlaceHolderApiClient $apiClient,
        private readonly JsonPlaceHolderAuthorTransformer $transformer
    ) {
    }

    public function find(int $id): Author
    {
        return $this->transformer->transformToAuthor(
            $this->apiClient->fetchAuthorById($id)
        );
    }

    public function exists(int $id): bool
    {
        try {
            $this->find($id);

            return true;
        } catch (\Throwable $th) {
        }

        return false;
    }
}
