<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin', name: 'admin_')]
class UserController extends AbstractController
{
    #[Route('/user/liste/inscription', name: 'liste_inscription')]
    public function index(UserRepository $userRepository): Response
    {


        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user/liste/detail/inscript/{id}', name: 'user_detail')]
    public function detailUser(UserRepository $userRepository, User $user): Response
    {

        return $this->render('admin/user/detailInscript.html.twig', [
            'user' => $user,
        ]);
    }
}
