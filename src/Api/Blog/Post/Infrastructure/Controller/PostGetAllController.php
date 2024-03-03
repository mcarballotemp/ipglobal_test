<?php

namespace App\Api\Blog\Post\Infrastructure\Controller;

use App\Api\Blog\Post\Application\DTO\PostDTO;
use App\Api\Blog\Post\Application\GetAllPost;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostGetAllController implements ControllerInterface
{
    public function __construct(
        private readonly GetAllPost $getAllPosts
    ) {
    }

    #[Route('blog/posts', name: 'get_posts', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Return All Posts',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: PostDTO::class)),
        )
    )]
    #[OA\Tag(name: 'Blog - Post')]
    public function getAllPosts(): JsonResponse
    {
        $posts = $this->getAllPosts->__invoke();

        return new JsonResponse($posts, Response::HTTP_OK);
    }
}
