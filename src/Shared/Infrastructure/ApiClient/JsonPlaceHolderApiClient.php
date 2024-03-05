<?php

namespace App\Shared\Infrastructure\ApiClient;

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
 * @phpstan-type PostJSonData array{id: int, userId: int, title: string, body: string}
 */
class JsonPlaceHolderApiClient
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $apiUrlJsonPlaceholder
    ) {
    }

    /**
     * @return PostJSonData
     */
    public function fetchPostById(int $id): array
    {
        $response = $this->client->request(
            'GET',
            $this->apiUrlJsonPlaceholder.'/posts/'.$id
        );

        if (200 === $response->getStatusCode()) {
            $data = $response->toArray();

            return [
                'id' => intval($data['id']),
                'userId' => intval($data['userId']),
                'title' => $data['title'],
                'body' => $data['body'],
            ];
        }

        throw new JsonPlaceHolderRequestError('Error on Fetching Post by Id');
    }

    /**
     * @return array<PostJSonData>
     */
    public function fetchPosts(): array
    {
        $response = $this->client->request(
            'GET',
            $this->apiUrlJsonPlaceholder.'/posts'
        );

        if (200 === $response->getStatusCode()) {
            return $response->toArray();
        }

        return [];
    }

    /**
     * @return AuthorJsonData
     */
    public function fetchAuthorById(int $id)
    {
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

        throw new JsonPlaceHolderRequestError('Error on Fetching Author by ID');
    }

    public function savePost(
        string $title,
        string $body,
        int $authorId,
    ): int {
        $response = $this->client->request(
            'POST',
            $this->apiUrlJsonPlaceholder.'/posts',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode(
                    [
                        'title' => $title,
                        'body' => $body,
                        'userId' => $authorId,
                    ]
                ),
            ]
        );

        if (201 === $response->getStatusCode()) {
            return (int) $response->toArray()['id'];
        }

        throw new JsonPlaceHolderRequestError('Error on saving Post');
    }
}
