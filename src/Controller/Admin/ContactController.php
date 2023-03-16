<?php

namespace App\Controller\Admin;

use App\Entity\Email;
use App\Form\Admin\AdminEnvoyeMailType;
use App\Repository\ContactRepository;
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
    #[Route('/contact/liste', name: 'contact_liste')]
    public function index(ContactRepository $contactRepository): Response
    {

        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contactRepository->findAll()
        ]);
    }
}
