<?php

namespace App\Api\Blog\Author\Application;

use App\Api\Blog\Author\Domain\AuthorRepository;
use App\Api\Blog\Author\Application\DTO\AuthorAddressDTO;
use App\Api\Blog\Author\Application\DTO\AuthorAddressGeoDTO;
use App\Api\Blog\Author\Application\DTO\AuthorCompanyDTO;
use App\Api\Blog\Author\Application\DTO\AuthorDTO;

class GetByIdAuthor
{
    public function __construct(
        private readonly AuthorRepository $repository
    ) {
    }

    public function __invoke(int $id): AuthorDTO
    {
        $author = $this->repository->find($id);

        return new AuthorDTO(
            $author->id->value(),
            $author->name->value(),
            $author->email->value(),
            new AuthorAddressDTO(
                $author->address->street()->value(),
                $author->address->suite()->value(),
                $author->address->city()->value(),
                $author->address->zipcode()->value(),
                new AuthorAddressGeoDTO(
                    $author->address->geo()->lat()->value(),
                    $author->address->geo()->lat()->value(),
                )
            ),
            $author->phone->value(),
            $author->website->value(),
            new AuthorCompanyDTO(
                $author->company->name()->value(),
                $author->company->catchPhrase()->value(),
                $author->company->bs()->value(),
            )
        );
    }
}
