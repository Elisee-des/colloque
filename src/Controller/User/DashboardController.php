<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/user/dashboard', name: 'app_user_dashboard')]
    public function index(): Response
    {
        return $this->render('user/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
