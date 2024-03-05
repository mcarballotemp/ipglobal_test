<?php

namespace App\Api\Blog\Author\Infrastructure\Repository;

use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Api\Blog\Shared\Domain\AuthorCheckIfExists;
use App\Shared\Infrastructure\ApiClient\JsonPlaceHolderApiClient;

/**
 * @phpstan-import-type AuthorJsonData from JsonPlaceHolderApiClient
 */
class JsonPlaceHolderAuthorRepository implements AuthorRepository, AuthorCheckIfExists
{
    public function __construct(
        private readonly JsonPlaceHolderApiClient $apiClient,
    ) {
    }

    public function find(int $id): Author
    {
        return $this->transformToAuthor(
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

    /**
     * @param AuthorJsonData $author
     */
    private function transformToAuthor($author): Author
    {
        return Author::fromPrimitives(
            $author['id'],
            $author['name'],
            $author['email'],
            $author['address']['street'],
            $author['address']['suite'],
            $author['address']['city'],
            $author['address']['zipcode'],
            $author['address']['geo']['lat'],
            $author['address']['geo']['lng'],
            $author['phone'],
            $author['website'],
            $author['company']['name'],
            $author['company']['catchPhrase'],
            $author['company']['bs'],
        );
    }
}
