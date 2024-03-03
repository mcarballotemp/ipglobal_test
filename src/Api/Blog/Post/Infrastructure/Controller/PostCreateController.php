<?php

namespace App\Api\Blog\Post\Infrastructure\Controller;

use App\Api\Blog\Post\Application\GetAllPost;
use App\Api\Blog\Post\Infrastructure\DTO\PostCreateInputDTO;
use App\Shared\Controller\ControllerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostCreateController implements ControllerInterface
{
    public function __construct(
        private readonly GetAllPost $getAllPosts
    ) {
    }

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
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        $input = $serializer->deserialize($request->getContent(), PostCreateInputDTO::class, 'json');
        print_r($input);
        $errors = (string) $validator->validate($input);
        print_r($errors);
        exit('hola');
        $loquesea = new PostCreateInputDTO(intval($data['id']), $data['title']);
        print_r($loquesea);
        exit('vale');

        return new JsonResponse([], 200);
    }
}
