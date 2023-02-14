<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class ChartController extends AbstractController
{
    #[Route('/chart', name: 'chart')]
    public function index(): Response
    {
        

        return $this->render('user/chart/index.html.twig', [
            'controller_name' => 'ChartController',
        ]);
    }
}
