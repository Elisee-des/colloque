<?php

namespace App\Controller\User;

use App\Entity\Message;
use App\Form\User\MessageType;
use App\Repository\MessageRepository;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class DiscussionController extends AbstractController
{
    #[Route('/discussion', name: 'discussion')]
    public function index(ReponseRepository $reponseRepository, MessageRepository $messageRepository): Response
    {
        return $this->render('user/discussion/index.html.twig', [
            'messages' => $messageRepository->findAll(),
            'reponses' => $reponseRepository->findAll()
        ]);
    }

    #[Route('/discussion/envoie-message', name: 'discussion_message')]
    public function creationMessage(Request $request, EntityManagerInterface $em): Response
    {
        $message = new Message();
        $user = $this->getUser();
        
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $message->setDateCreation(new \DateTime());
            $message->setUser($user);
            
            $em->persist($message);
            $em->flush();

            $this->addFlash(
               'success',
               'Votre message a bien été envoyé avec succès. vous serrez repondu dans les plus bref délais'
            );

            return $this->redirectToRoute('user_discussion');
        }

        return $this->render('user/discussion/message.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    #[Route('/discussion/edition-message/{id}', name: 'edition_message')]
    public function editionMessage(Message $message, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $message->setDateCreation(new \DateTime());
            $message->setUser($user);
            
            $em->persist($message);
            $em->flush();

            $this->addFlash(
               'success',
               'Votre message a bien été modifier avec succès. vous serrez repondu dans les plus bref délais'
            );

            return $this->redirectToRoute('user_discussion');
        }

        return $this->render('user/discussion/messageEdition.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
