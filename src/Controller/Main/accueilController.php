<?php

namespace App\Controller\Main;

use App\Entity\Contact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class accueilController extends AbstractController
{
    #[Route('/', name: 'main_accueil')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        
        if (isset($_POST["contact"])) {
            $nomPrenom = $request->get("nom");
            $email = $request->get("email");
            $sujet = $request->get("sujet");
            $numero = $request->get("numero");
            $message = $request->get("message");
            if ($nomPrenom != "" && $email != "" && $sujet != "" && $message != "" && $numero != "") {
                
                $contact->setNomPrenom($nomPrenom)
                ->setEmail($email)
                ->setSujet($sujet)
                ->setMessage($message)
                ->setNumero($numero);
                ;
                
                $em->persist($contact);
                $em->flush();
                
                return $this->redirectToRoute('main_accueil_success_contact');
            }
        }

        return $this->render('main/accueil/index.html.twig', [
            'controller_name' => 'accueilController',
        ]);
    }

    #[Route('/success-envoie-message', name: 'main_accueil_success_contact')]
    public function contact(): Response
    {

        return $this->render('main/includes/success.html.twig');
    }
}
