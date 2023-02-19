<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class DiscussionController extends AbstractController
{
    #[Route('/discussion', name: 'discussion')]
    public function index(): Response
    {
        return $this->render('admin/discussion/index.html.twig', [
            'controller_name' => 'DiscussionController',
        ]);
    }
}
