<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class ParametreController extends AbstractController
{
    #[Route('/parametre', name: 'parametre')]
    public function index(): Response
    {
        return $this->render('user/parametre/index.html.twig', [
            'controller_name' => 'ParametreController',
        ]);
    }
}
