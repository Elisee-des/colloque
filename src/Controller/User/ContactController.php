<?php

namespace App\Controller\User;

use App\Entity\Email;
use App\Form\User\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request): Response
    {
        $emailContact = new Email();

        $form = $this->createForm(ContactType::class, $emailContact);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            dd();
        }

        return $this->render('user/contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
