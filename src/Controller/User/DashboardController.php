<?php

namespace App\Controller\User;

use App\Form\User\EditeImagePayementType;
use App\Form\User\EditeResumeType;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('user/dashboard/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/editer/profil', name: 'editer_profif')]
    public function editerProfil(Request $request, EntityManagerInterface $em): Response
    {
        /**
         * @var User
         */

        $user = $this->getUser();

        if(isset($_POST["modifierInformation"]))
        {
            $nom = $request->get("nom");
            $prenom = $request->get("prenom");

            $user->setNom($nom)
                ->setPrenom($prenom);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec success votre profile'
            );
        }

        return $this->render('user/dashboard/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/editer/resumer', name: 'editer_resumer')]
    public function editerResumer(Request $request, EntityManagerInterface $em, UploaderService $uploaderService): Response
    {
        /**
         * @var User
         */

        $user = $this->getUser();

        $form = $this->createForm(EditeResumeType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $fichier = $form->get("resumeFile")->getData();
            $resumerFichier = $uploaderService->uploader($fichier);
            
            $user->setResume($resumerFichier);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec success votre profile'
            );

            return $this->redirectToRoute('user_dashboard');

        }

        return $this->render('user/dashboard/editResumer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    #[Route('/editer/imagePayement', name: 'editer_imagePayement')]
    public function editerImagePayement(Request $request): Response
    {

        $form = $this->createForm(EditeImagePayementType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            dd($request);
        }

        return $this->render('user/dashboard/imagePayement.html.twig', [
            // 'user' => $user,
        ]);
    }
}
