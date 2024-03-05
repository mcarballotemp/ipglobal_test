<?php

namespace App\Shared\Infrastructure\ApiClient;

class JsonPlaceHolderRequestError extends \RuntimeException
{
    public function __construct(string $msg)
    {
        parent::__construct($msg);
    }
}
