<?php

namespace App\Controller\User;

use App\Entity\File;
use App\Form\User\EditeImagePayementType;
use App\Form\User\EditerAxeType;
use App\Form\User\EditeResumeType;
use App\Repository\FileRepository;
use App\Repository\ImageFileRepository;
use App\Repository\UserRepository;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/editer/resumer/{id}', name: 'editer_resumer')]
    public function editerResumer(Request $request, EntityManagerInterface $em, UploaderService $uploaderService, $id, UserRepository $userRepository): Response
    {
        /**
         * @var User
         */

        $user = $this->getUser();
        $user = $userRepository->find($id);

        
        $form = $this->createForm(EditeResumeType::class);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $fichier = $form->get("resumeFile")->getData();
            $nouveauxNom = $uploaderService->uploader($fichier);
            $nomFichier = $fichier->getClientOriginalName();
            
            $user->setResumer($nouveauxNom)
                ->setResumerNouveauNom($nomFichier);

            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec success votre resumer'
            );

            return $this->redirectToRoute('user_dashboard');

        }

        return $this->render('user/dashboard/editResumer.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/editer/imagePayement/{id}', name: 'editer_imagePayement')]
    public function editerImagePayement(Request $request, UploaderService $uploaderService, EntityManagerInterface $em, $id, UserRepository $userRepository): Response
    {
        /**
         * @var User
         */

         $user = $this->getUser();
         $user = $userRepository->find($id);

        $form = $this->createForm(EditeImagePayementType::class);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $fichier = $form->get("imagePayementFile")->getData();
            $imagePayementFichier = $uploaderService->uploader($fichier);
            $nomFichier = $fichier->getClientOriginalName();
            
            $user->setImagePayment($imagePayementFichier)
                ->setImagePayementNouveauNom($nomFichier);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec success votre image de payement'
            );

            return $this->redirectToRoute('user_dashboard');

        }

        return $this->render('user/dashboard/imagePayement.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    #[Route('/editer/axe', name: 'editer_axe')]
    public function editerAxe(Request $request, EntityManagerInterface $em): Response
    {
        /**
         * @var User
         */

        $user = $this->getUser();

        $form = $this->createForm(EditerAxeType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec success votre Axe'
            );

            return $this->redirectToRoute('user_dashboard');

        }

        return $this->render('user/dashboard/editAxe.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/editer/motdepasse', name: 'editer_password')]
    public function editerPassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHash): Response
    {
        /**
         * @var User
         */

        $user = $this->getUser();

        if(isset($_POST["Modifier"]))
        {
            $nouveauPassword = $request->get("newpassword");
            $passwordRepeter = $request->get("renewpassword");
            
            if($nouveauPassword == $passwordRepeter);
            {
                $nouveauPasswordHash = $passwordHash->hashPassword($user, $nouveauPassword);
                $user->setPassword($nouveauPasswordHash);
            
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Vous avez modifier avec success votre profile'
                );
               }

                $this->addFlash(
                    'success',
                    "Votre mot de passe n'est pas identique. Veuillez ressaié"
                );

        }

        return $this->redirectToRoute('user_dashboard');

    }
}
