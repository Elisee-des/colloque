<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/admin/inscription', name: 'app_admin_inscription')]
    public function index(): Response
    {
        

        return $this->render('admin/inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }
}
