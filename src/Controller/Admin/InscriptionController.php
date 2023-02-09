<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\InscriptionType;
use App\Repository\UserRepository;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function index(Request $request, EntityManagerInterface $em,
    UploaderService $uploaderService, UserPasswordHasherInterface $passwordhasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);


        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $users = $userRepository->findAll();
            $numero = count($users);
            $numeroUser = $numero+1;

            $passwordClaire = $request->get("inscription")["password"]["first"];
            $password = $passwordhasher->hashPassword($user, $passwordClaire);
            $communication = $form->get("communicationFile")->getData();
            $resumer = $form->get("resumeFile")->getData();
            $imagePayement = $form->get("imagePayementFile")->getData();

            if($communication == NULL)
            {
                $user->setCommunication($communication);
            }

            if($resumer == NULL)
            {
                $user->setResume($resumer);
            }

            if($imagePayement == NULL)
            {
                $user->setImagePayement($imagePayement);
            }

            else {
                $nouveauNom1 = $uploaderService->uploader($communication);
                $nouveauNom2 = $uploaderService->uploader($resumer);
                $nouveauNom3 = $uploaderService->uploader($imagePayement);

                $user->setCommunication($nouveauNom1)
                ->setResume($nouveauNom2)
                ->setImagePayement($nouveauNom3);
            }

            $user
            ->setPassword($password)
            ->setContact($numeroUser)
            ->setTerms(true)
            ->setAPayer(false);
            
            $em->persist($user);
            $em->flush();
            
            $this->addFlash(
                'success',
                'Vous avez reussi votre inscription'
            );
            
            return $this->redirectToRoute('inscription_success');

        }

        return $this->render('admin/inscription/index.html.twig', [
            'formulaireInscription' => $form->createView(),
        ]);

    }

    #[Route('/inscription/success', name: 'inscription_success')]
    public function succes(): Response
    {
        $user = $this->getUser();

        return $this->render('admin/inscription/success.html.twig', [
            'user' => $user,
        ]);
    }



}
