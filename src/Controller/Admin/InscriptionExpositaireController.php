<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\InscriptionExpositaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionExpositaireController extends AbstractController
{
    #[Route('/inscription/expositaire', name: 'inscription_expositaire')]
    public function index(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(InscriptionExpositaireType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
        }

        return $this->render('admin/inscription_expositaire/index.html.twig', [
            'formulaireInscription' => $form->createView()
        ]);
    }
}
