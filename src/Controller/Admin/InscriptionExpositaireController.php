<?php

namespace App\Controller\Admin;

use App\Entity\Expositaire;
use App\Entity\User;
use App\Form\Admin\InscriptionExpositaireType;
use App\Repository\ExpositaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionExpositaireController extends AbstractController
{
    #[Route('/inscription/expositaire', name: 'inscription_exposants')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        if (isset($_POST["inscription_expt"])) {
            
            dd($request);
            $expositaire = new Expositaire();
            
            $expositaire->setNumero(0);
            $em->persist($expositaire);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous êtés inscript avec success en tant que expositaire au colloque.'
            );

            return $this->redirectToRoute('success_inscription_expositaire');
        }

        $this->addFlash(
            'error',
            'Veuillez remplir le formulaire.'
        );


        return $this->render('admin/inscription_expositaire/index.html.twig', [
            // 'formulaireInscription' => $form->createView()
        ]);
    }

    #[Route('/inscription/expositaire/success', name: 'success_inscription_expositaire')]
    public function success(): Response
    {
        // $user = $this->getUser();

        return $this->render('admin/inscription_expositaire/success.html.twig', [
            // 'user' => $user,
        ]);
    }
}
