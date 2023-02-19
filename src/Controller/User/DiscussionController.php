<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class DiscussionController extends AbstractController
{
    #[Route('/discussion', name: 'discussion')]
    public function index(): Response
    {
        return $this->render('user/discussion/index.html.twig', [
            'controller_name' => 'DiscussionController',
        ]);
    }

    #[Route('/discussion/envoie-message', name: 'discussion_message')]
    public function creationMessage(): Response
    {
        return $this->render('user/discussion/index.html.twig', [
            'controller_name' => 'DiscussionController',
        ]);
    }
}
