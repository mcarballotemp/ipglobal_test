<?php

namespace App\Api\Blog\Post\Infrastructure\Controller;

use App\Api\Blog\Post\Application\CreatePost;
use App\Api\Blog\Post\Infrastructure\DTO\PostCreateInputDTO;
use App\Shared\Controller\BaseController;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostCreateController extends BaseController implements ControllerInterface
{
    #[Route('blog/posts', name: 'post_posts', methods: ['POST'])]
    #[OA\RequestBody(
        request: 'CreateBlogPost',
        description: 'Create a new blog post',
        required: true,
        content: new OA\JsonContent(
            ref: new Model(type: PostCreateInputDTO::class)
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Blog post created successfully',
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid request data'
    )]
    #[OA\Tag(name: 'Blog - Post')]
    public function createPost(
        Request $request,
        CreatePost $createPost
    ): JsonResponse {
        [$input, $errors] = $this->deserializeAndValidate($request, PostCreateInputDTO::class);

        if ($errors) {
            return $this->respondWithValidationErrors($errors);
        }

        if (!$input) {
            return new JsonResponse('', Response::HTTP_BAD_REQUEST);
        }

        try {
            return new JsonResponse(
                $createPost->__invoke(
                    $input->authorId,
                    $input->title,
                    $input->body
                ),
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return new JsonResponse($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
