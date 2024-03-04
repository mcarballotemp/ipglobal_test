<?php

namespace App\Front\Controller;

use App\Shared\Controller\ControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController implements ControllerInterface
{
    #[Route('/')]
    public function index(): RedirectResponse
    {
        return $this->redirect('/api/doc');
    }
}
