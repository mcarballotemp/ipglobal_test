<?php

namespace App\Shared\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T> $classType
     *
     * @return array{0: T|null, 1:ConstraintViolationListInterface|null}
     */
    protected function deserializeAndValidate(
        Request $request,
        string $classType
    ): array {
        /** @var T */
        $object = $this->serializer->deserialize(
            $request->getContent(),
            $classType,
            'json'
        );
        $errors = $this->validator->validate($object);

        if (count($errors) > 0) {
            return [null, $errors];
        }

        return [$object, null];
    }

    protected function respondWithValidationErrors(
        ConstraintViolationListInterface $errors
    ): JsonResponse {
        $readableErrors = array_map(function ($e) {
            return $e->getPropertyPath().': '.$e->getMessage();
        }, iterator_to_array($errors));

        return new JsonResponse(['errors' => $readableErrors], Response::HTTP_BAD_REQUEST);
    }
}
