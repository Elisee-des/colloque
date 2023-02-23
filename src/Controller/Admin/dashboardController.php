<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class dashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $compt = 0;

        foreach ($users as $user) {
            if ($user->getResume() == '') {
                $compt = $compt + 1;
            }
        }

        return $this->render('admin/dashboard/index.html.twig', [
            'nbrposters' => $compt,
        ]);
    }
}
