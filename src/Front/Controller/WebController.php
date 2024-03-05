<?php

namespace App\Front\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/web')]
class WebController extends AbstractController
{
    #[Route('{slug}', requirements: ['slug' => '.+'])]
    public function web(): Response
    {
        return $this->render('@Front/base.html.twig');
    }
}
