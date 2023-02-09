<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\EditionParticipantType;
use App\Form\Admin\editionPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/participants/detail/{id}', name: 'participant_detail')]
    public function detailUser(User $participant): Response
    {

        return $this->render('admin/participant/detail.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[Route('/participant/edition/{id}', name: 'edition_participant')]
    public function edition(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EditionParticipantType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec succes les informations de cet utilisateur'
            );

            return $this->redirectToRoute('admin_participant_detail', ["id"=> $user->getId()]);
            
        }

        return $this->render('admin/participant/edition.html.twig', [
            'form' => $form->createView(),
            'participant' => $user
        ]);
    }

    #[Route('/edition/motdepasse/{id}', name: 'user_edition_password')]
    public function editionPassword(User $user, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordhasher): Response
    {
        $form = $this->createForm(editionPasswordType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $passwordClaire = $request->get("edition_password")["password"]["first"];
            $password = $passwordhasher->hashPassword($user, $passwordClaire);
            
            $user->setPassword($password);
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous modifier avec success le mot de passe de cette utilisateur'
            );

            return $this->redirectToRoute('admin_user_detail', ["id"=> $user->getId()]);
            
        }

        return $this->render('admin/user/editionPassword.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

}
