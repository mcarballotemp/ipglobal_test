<?php

namespace App\Api\Blog\Author\Infrastructure\Repository;

use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorNotExists;
use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Api\Blog\Shared\Domain\AuthorCheckIfExists;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @phpstan-type AuthorJsonData array{
 *   id: int,
 *   name: string,
 *   email: string,
 *   address: array{
 *     street: string,
 *     suite: string,
 *     city: string,
 *     zipcode: string,
 *     geo: array{
 *       lat: string,
 *       lng: string
 *     }
 *   },
 *   phone: string,
 *   website: string,
 *   company: array{
 *     name: string,
 *     catchPhrase: string,
 *     bs: string
 *   }
 * }
 */
class JsonPlaceHolderAuthorRepository implements AuthorRepository, AuthorCheckIfExists
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrlJsonPlaceholder
    ) {
    }

    public function find(int $id): Author
    {
        return $this->transformToAuthor($this->fetchAuthorById($id));
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
     * @return AuthorJsonData
     */
    private function fetchAuthorById(int $id)
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrlJsonPlaceholder.'/users/'.$id
            );

            if (200 === $response->getStatusCode()) {
                $data = $response->toArray();

                return [
                    'id' => intval($data['id']),
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'address' => [
                        'street' => $data['address']['street'],
                        'suite' => $data['address']['suite'],
                        'city' => $data['address']['city'],
                        'zipcode' => $data['address']['zipcode'],
                        'geo' => [
                            'lat' => $data['address']['geo']['lat'],
                            'lng' => $data['address']['geo']['lng'],
                        ],
                    ],
                    'website' => $data['website'],
                    'phone' => $data['phone'],
                    'company' => [
                        'name' => $data['company']['name'],
                        'catchPhrase' => $data['company']['catchPhrase'],
                        'bs' => $data['company']['bs'],
                    ],
                ];
            }
        } catch (\Throwable $th) {
        }

        throw new AuthorNotExists();
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
