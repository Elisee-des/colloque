<?php

namespace App\Controller\Admin;

use App\Entity\Reponse;
use App\Form\Admin\ReponseType;
use App\Repository\MessageRepository;
use App\Repository\ReponseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class ReponseController extends AbstractController
{

    #[Route('/reponse/liste-des-utilisteur-ayant-un-message', name: 'reponse_liste')]
    public function liste(UserRepository $userRepository): Response
    {
        $userss = $userRepository->findAll();

        // foreach ($userss as $user) {
        //     if ($user->isAEnvoyer() == 1) {
        //         $users[] = $user;
        //     }
        // }
        
        return $this->render('admin/reponse/liste.html.twig', [
            // 'users' => $users,
        ]);
    }

    #[Route('/reponse/detail-des-message/{id}', name: 'detail_reponse')]
    public function detailMessage($id, UserRepository $userRepository): Response
    {
       $user = $userRepository->find($id)->getMessages();
       dd($user);
        
        return $this->render('admin/reponse/detail.html.twig', [
            'user' => $user,
            // 'messages' => $user->getMessages(),
        ]);
    }

    
    #[Route('/reponse/envoie-reponse', name: 'discussion_reponse')]
    public function creationReponse(Request $request, EntityManagerInterface $em): Response
    {
        $reponse = new Reponse();
        
        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $reponse->setDateCreation(new \DateTime());
            
            $em->persist($reponse);
            $em->flush();

            $this->addFlash(
               'success',
               'Votre Reponse a bien été envoyé avec succès.'
            );

            return $this->redirectToRoute('admin_discussion');
        }

        return $this->render('admin/reponse/creationReponse.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
