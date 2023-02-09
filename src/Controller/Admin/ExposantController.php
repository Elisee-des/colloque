<?php

namespace App\Controller\Admin;

use App\Entity\Expositaire;
use App\Entity\User;
use App\Repository\ExpositaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Path;

#[Route('/admin', name: 'admin_')]
class ExposantController extends AbstractController
{

    #[Route('/liste/inscription/exposant', name: 'liste_inscription_exposants')]
    public function index(ExpositaireRepository $exposantRepository): Response
    {

        return $this->render('admin/exposant/index.html.twig', [
            'exposants' => $exposantRepository->findAll(),
        ]);
    }

    #[Route('/exposant/detail/{id}', name: 'exposant_detail')]
    public function detailUser(Expositaire $exposant): Response
    {

        return $this->render('admin/exposant/detail.html.twig', [
            'exposant' => $exposant,
        ]);
    }

    #[Route('exposant/edition/{id}', name: 'edition_exposant')]
    public function edition(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(editionCompteInscriptionType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec succes les informations de cet utilisateur'
            );

            return $this->redirectToRoute('admin_user_detail', ["id"=> $user->getId()]);
            
        }

        return $this->render('admin/user/editionCompteInscription.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

 
}
