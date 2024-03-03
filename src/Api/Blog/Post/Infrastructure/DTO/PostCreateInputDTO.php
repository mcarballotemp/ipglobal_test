<?php

namespace App\Api\Blog\Post\Infrastructure\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PostCreateInputDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $id,

        #[Assert\NotBlank]
        public string $title,
    ) {
    }
}
