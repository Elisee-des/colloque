<?php

namespace App\Controller\Admin;

use App\Repository\ExpositaireRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class dashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(UserRepository $userRepository, ExpositaireRepository $expositaireRepository): Response
    {
        $users = $userRepository->findAll();
        $users2 = $userRepository->findAll();
        $usersTri = $userRepository->findBy([], ["id" => "DESC"], 5);
        $expositaires = $expositaireRepository->getEtat();
        $totalExpositaires = $expositaires["etat"][0];
        $totalUsers = $expositaires["etat1"][0];
        $compt = 0;
        $compt2 = 0;

        foreach ($users as $user) {
            if ($user->getResumer() != '') {
                $compt = $compt + 1;
            }
        }

        foreach ($users2 as $user) {
            if ($user->getImagePayment() != '') {
                $compt2 = $compt2 + 1;
            }
        }
 
        return $this->render('admin/dashboard/index.html.twig', [
            'nbrposters' => $compt,
            'totalExpositaires' => $totalExpositaires,
            'totalUsers' => $totalUsers,
            'users' => $usersTri,
            'totalPayer' => $compt2
        ]);
    }
}
