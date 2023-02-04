<?php

namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class accueilController extends AbstractController
{
    #[Route('/', name: 'main_accueil')]
    public function index(): Response
    {
        return $this->render('main/accueil/index.html.twig', [
            'controller_name' => 'accueilController',
        ]);
    }
}
