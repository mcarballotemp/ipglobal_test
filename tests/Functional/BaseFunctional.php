<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseFunctional extends WebTestCase
{
    protected KernelBrowser $client;

    protected \Faker\Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->faker = \Faker\Factory::create();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
    }

    public static function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn () => null);

            restore_exception_handler();

            if (null === $previousHandler) {
                break;
            }

            restore_exception_handler();
        }
    }
}
