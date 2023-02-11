<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Admin\InscriptionType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginAuthenticator;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function register(Request $request, UserPasswordHasherInterface $passwordhasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager, UploaderService $uploaderService, UserRepository $userRepository): Response
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
            $resumer = $form->get("resumeFile")->getData();
            $imagePayement = $form->get("imagePayementFile")->getData();

            if($resumer == NULL)
            {
                $user->setResume($resumer);
            }

            if($imagePayement == NULL)
            {
                $user->setImagePayement($imagePayement);
            }

            else {
                $nouveauNom2 = $uploaderService->uploader($resumer);
                $nouveauNom3 = $uploaderService->uploader($imagePayement);

                $user
                ->setResume($nouveauNom2)
                ->setImagePayement($nouveauNom3);
            }

            $user->setPassword($password)
            ->setContact($numeroUser)
            ->setTerms(true)
            ->setAPayer(false);
            // encode the plain password

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Vous avez reussi votre inscription'
            );
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('admin/inscription/index.html.twig', [
            'formulaireInscription' => $form->createView(),
        ]);
    }
}
