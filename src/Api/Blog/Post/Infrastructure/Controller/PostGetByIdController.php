<?php

namespace App\Api\Blog\Post\Infrastructure\Controller;

use App\Api\Blog\Post\Application\GetByIdPost;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Infrastructure\DTO\PostGetByIdOutputDTO;
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
            type: 'array',
            items: new OA\Items(ref: new Model(type: PostGetByIdOutputDTO::class)),
        )
    )]
    #[OA\Tag(name: 'Blog - Post')]
    public function getById(int $id): JsonResponse
    {
        /** @var Post */
        $post = $this->getByIdPost->__invoke($id);

        $output = new PostGetByIdOutputDTO(
            $post->id->value(),
            $post->authorId->value(),
            $post->title->value(),
            $post->body->value()
        );

        return new JsonResponse($output, Response::HTTP_OK);
    }
}
