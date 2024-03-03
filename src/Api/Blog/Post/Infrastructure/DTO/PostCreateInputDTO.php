<?php

namespace App\Api\Blog\Post\Infrastructure\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PostCreateInputDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThan(value: 0)]
        public int $authorId,

        #[Assert\NotBlank]
        #[Assert\Length(max: 256)]
        public string $title,

        #[Assert\NotBlank]
        #[Assert\Length(max: 4096)]
        public string $body,
    ) {
    }
}
