<?php

namespace App\Api\Blog\Post\Infrastructure\Controller;

use App\Api\Blog\Post\Application\DTO\PostDTO;
use App\Api\Blog\Post\Application\GetByIdPost;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostGetByIdController implements ControllerInterface
{
    public function __construct(
        private readonly GetByIdPost $getByIdPost
    ) {
    }

    #[Route('blog/posts/{id}', name: 'get_post_by_id', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return Post By Id',
        content: new OA\JsonContent(
            ref: new Model(type: PostDTO::class),
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
            $post = $this->getByIdPost->__invoke($id);

            return new JsonResponse($post, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return new JsonResponse(
                $th->getMessage(),
                404
            );
        }
    }
}
