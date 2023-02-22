<?php

namespace App\Controller\Admin;

use App\Entity\Email;
use App\Form\Admin\AdminEnvoyeMailType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $newEmail = new Email();
        $form = $this->createForm(AdminEnvoyeMailType::class, $newEmail);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $id = $request->get('admin_envoye_mail')['nom'];
            $emailTo = $userRepository->find($id)->getEmail();
            $nom = $userRepository->find($id)->getNom();
            $sujet = $request->get('admin_envoye_mail')['sujet'];
            $message = $request->get('admin_envoye_mail')['message'];

            // $email = new Mail();
            // $email->AdminEnvoyeEmail($emailTo, $nom, $sujet, $message);

            

            $this->addFlash(
                'success',
                "Votre email a bien ete envoyez"
            );

            return $this->redirectToRoute('admin_contact');
            
        }

        return $this->render('admin/contact/index.html.twig', [
            'form' => $form->createView()   
        ]);
    }
}
