<?php

namespace App\Api\Blog\Author\Infrastructure\Transformer;

use App\Api\Blog\Author\Domain\Author;

/**
 * @phpstan-import-type AuthorJsonData from \App\Shared\Infrastructure\ApiClient\JsonPlaceHolderApiClient
 */
class JsonPlaceHolderAuthorTransformer
{
    /**
     * @param AuthorJsonData $author
     */
    public function transformToAuthor($author): Author
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
