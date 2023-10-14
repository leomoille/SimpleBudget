<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default_homepage')]
    public function index(): Response
    {
        if (null !== $this->getUser()) {
            return $this->redirectToRoute('app_budget');
        }

        return $this->render('default/index.html.twig');
    }
}
