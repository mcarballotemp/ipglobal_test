<?php

namespace App\Api\Blog\Post\Infrastructure\Controller;

use App\Api\Blog\Shared\Application\DTO\PostWithAuthorDTO;
use App\Api\Blog\Shared\Application\GetPostByIdWithAuthor;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostGetByIdWithAuthorController implements ControllerInterface
{
    public function __construct(
        private readonly GetPostByIdWithAuthor $getPostByIdWithAuthor
    ) {
    }

    #[Route('blog/posts/{id}/with/author', name: 'get_post_by_id_with_author', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return Post By Id With Author',
        content: new OA\JsonContent(
            ref: new Model(type: PostWithAuthorDTO::class),
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Author not found'
    )]
    #[OA\Tag(name: 'Blog - Post')]
    public function getById(int $id): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->getPostByIdWithAuthor->__invoke($id),
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return new JsonResponse(
                $th->getMessage(),
                404
            );
        }
    }
}
