<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class ParticipantController extends AbstractController
{
    #[Route('/participants', name: 'participant')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        foreach($users as $user)
        {
            $resumer = $user->getResume();
            if($resumer == '')
            {
                $participants[] = $user;
            }
        }

        return $this->render('admin/participant/index.html.twig', [
            'participants' => $participants,
        ]);
    }
}
