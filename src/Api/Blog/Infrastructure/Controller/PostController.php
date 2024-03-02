<?php

namespace App\Api\Blog\Infrastructure\Controller;

use App\Api\Blog\Infrastructure\DTO\PostOutputDTO;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class PostController implements ControllerInterface
{
    #[Route('blog/posts', name: 'get_posts', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: "Return all Posts",
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: PostOutputDTO::class)),
        )
    )]
    #[OA\Tag(name: 'Blog - Post')]
    public function getPosts(): JsonResponse
    {
        return new JsonResponse('jsonResponse', 200);
    }
}
