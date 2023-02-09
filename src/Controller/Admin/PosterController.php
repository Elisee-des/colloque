<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class PosterController extends AbstractController
{
    #[Route('/poster', name: 'poster')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        foreach($users as $user)
        {
            $resumer = $user->getResume();
            if($resumer != '')
            {
                $posters[] = $user;
            }
        }

        return $this->render('admin/poster/index.html.twig', [
            'posters' => $posters,
        ]);
    }
}
