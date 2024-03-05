<?php

namespace App\Front\Controller;

use App\Shared\Controller\ControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController implements ControllerInterface
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('@Front/base.html.twig');
    }
}
