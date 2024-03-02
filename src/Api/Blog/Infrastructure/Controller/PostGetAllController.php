<?php

namespace App\Api\Blog\Infrastructure\Controller;

use App\Api\Blog\Application\GetAllPost;
use App\Api\Blog\Domain\Post\PostCollection;
use App\Api\Blog\Infrastructure\DTO\PostOutputDTO;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class PostGetAllController implements ControllerInterface
{
    public function __construct(
        private readonly GetAllPost $getAllPosts
    ) {
    }

    #[Route('blog/posts', name: 'get_posts', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: "Return All Posts",
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: PostOutputDTO::class)),
        )
    )]
    #[OA\Tag(name: 'Blog - Post')]
    public function getAllPosts(): JsonResponse
    {
        /** @var PostCollection */
        $postCollection = $this->getAllPosts->__invoke();

        $output = [];

        foreach ($postCollection->getAll() as $post) {
            $output[] = new PostOutputDTO(
                intval($post->getId()),
                $post->getTitle(),
                '',
                12
            );
        }

        return new JsonResponse($output, 200);
    }
}
