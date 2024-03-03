<?php

namespace App\Api\Blog\Post\Infrastructure\Controller;

use App\Api\Blog\Post\Application\GetAllPost;
use App\Api\Blog\Post\Domain\Post;
use App\Api\Blog\Post\Domain\PostCollection;
use App\Api\Blog\Post\Infrastructure\DTO\PostGetAllOutputDTO;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            items: new OA\Items(ref: new Model(type: PostGetAllOutputDTO::class)),
        )
    )]
    #[OA\Tag(name: 'Blog - Post')]
    public function getAllPosts(): JsonResponse
    {
        /** @var PostCollection */
        $postCollection = $this->getAllPosts->__invoke();

        $output = array_map(
            function (Post $post) {
                return new PostGetAllOutputDTO(
                    $post->id->value(),
                    $post->title->value()
                );
            },
            $postCollection->getAll()
        );

        return new JsonResponse($output, 200);
    }
}
