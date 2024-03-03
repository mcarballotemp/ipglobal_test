<?php

namespace App\Api\Blog\Author\Infrastructure\Controller;

use App\Api\Blog\Author\Application\GetByIdAuthor;
use App\Api\Blog\Author\Application\DTO\AuthorDTO;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthorGetByIdController implements ControllerInterface
{
    public function __construct(
        private readonly GetByIdAuthor $getByIdAuthor
    ) {
    }

    #[Route('blog/authors/{id}', name: 'get_author', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return Author By ID',
        content: new OA\JsonContent(
            ref: new Model(type: AuthorDTO::class),
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Author not found'
    )]
    #[OA\Tag(name: 'Blog - Author')]
    public function getAuthorById(int $id): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->getByIdAuthor->__invoke($id),
                200
            );
        } catch (\Throwable $th) {
            return new JsonResponse(
                $th->getMessage(),
                404
            );
        }
    }
}
