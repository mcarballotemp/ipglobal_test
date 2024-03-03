<?php

namespace App\Api\Blog\Author\Infrastructure\Repository;

use App\Api\Blog\Author\Domain\Author;
use App\Api\Blog\Author\Domain\AuthorNotExists;
use App\Api\Blog\Author\Domain\AuthorRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @phpstan-type AuthorData array{
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
 *   company: array{
 *     name: string,
 *     catchPhrase: string,
 *     bs: string
 *   }
 * }
 */
class JsonPlaceHolderAuthorRepository implements AuthorRepository
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrlJsonPlaceholder
    ) {
    }

    public function find(int $id): Author
    {
        $authorData = $this->fetchUserById($id);

        return $this->transform($authorData);
    }

    /**
     * @return AuthorData
     */
    private function fetchUserById(int $id): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->apiUrlJsonPlaceholder.'/users/'.$id
            );

            if (200 === $response->getStatusCode()) {
                $data = $response->toArray();

                return [
                    'id' => (int) $data['id'],
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
     * @param AuthorData $authorData
     */
    private function transform(array $authorData): Author
    {
        return Author::fromArray($authorData);
    }
}
