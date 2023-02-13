<?php

namespace App\Controller\Admin;

use App\Repository\HistoriqueConnexionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoriqueController extends AbstractController
{
    #[Route('/admin/historique', name: 'admin_historique')]
    public function index(HistoriqueConnexionRepository $historiqueConnexionRepository, UserRepository $userRepository): Response
    {
        return $this->render('admin/historique/index.html.twig', [
            'historiqueConnexions' => $historiqueConnexionRepository->findAll(),
            'users' => $userRepository->findAll()
        ]);
    }
}
