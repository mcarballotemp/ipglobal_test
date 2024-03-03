<?php

namespace App\Api\Blog\Author\Infrastructure\Controller;

use App\Api\Blog\Author\Application\GetById;
use App\Api\Blog\Author\Infrastructure\DTO\AuthorGetByIdOutputDTO;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthorGetByIdController implements ControllerInterface
{
    public function __construct(
        private readonly GetById $getById
    ) {
    }

    #[Route('blog/author/{id}', name: 'get_author', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return Author By ID',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AuthorGetByIdOutputDTO::class)),
        )
    )]
    #[OA\Tag(name: 'Blog - Author')]
    public function getAuthorById(int $id): JsonResponse
    {
        return new JsonResponse(
            AuthorGetByIdOutputDTO::fromAuthor(
                $this->getById->__invoke($id)
            ),
            200
        );
    }
}
