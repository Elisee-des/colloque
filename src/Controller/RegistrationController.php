<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\ImageFile;
use App\Entity\User;
use App\Form\Admin\InscriptionType;
use App\Repository\UserRepository;
use App\Security\LoginAuthenticator;
use App\Service\SenderMailService;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

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
            $numeroUser = $numero + 1;

            $passwordClaire = $request->get("inscription")["password"]["first"];
            $password = $passwordhasher->hashPassword($user, $passwordClaire);
            $resumer = $form->get("resumeFile")->getData();
            $imagePayement = $form->get("imagePayementFile")->getData();
            
            

            if ($resumer == '' && $imagePayement == '') {
                $user->setResumer('rien');
                $user->setImagePayment("rien");
                $user->setResumerNouveauNom("rien");
                $user->setImagePayementNouveauNom("rien");

                $user->setPassword($password);
                $user->setPoster(0);

                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    $this->addFlash(
                        'success',
                        'Vous avez reussi votre inscription'
                    );

                    return $this->redirectToRoute('inscription_success');
            }

            elseif ($resumer != '' && $imagePayement == '') {
                $vraiNomResumer = $resumer->getClientOriginalName();
                $nouveauNomResumer = $uploaderService->uploader($resumer);

                $user->setImagePayment("rien");

                $user->setPassword($password)
                    ->setResumer($nouveauNomResumer)
                    ->setResumerNouveauNom($vraiNomResumer)
                    
                    ;
                $user->setPoster(0);


                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    $this->addFlash(
                        'success',
                        'Vous avez reussi votre inscription'
                    );

                    return $this->redirectToRoute('inscription_success');


            }

            elseif ($resumer == '' && $imagePayement != '') {
            $vraiNomImage = $imagePayement->getClientOriginalName();
                $nouveauNomImage = $uploaderService->uploader($imagePayement);
                $user->setResumer("rien");

                $user->setPassword($password)
                    ->setImagePayment($nouveauNomImage)
                    ->setImagePayementNouveauNom($vraiNomImage)
                    ->setResumerNouveauNom("rien")
                    ;
                $user->setPoster(0);


                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    $this->addFlash(
                        'success',
                        'Vous avez reussi votre inscription'
                    );

                    return $this->redirectToRoute('inscription_success');
            }
            
            
            elseif ($resumer != '' && $imagePayement != '') {
            $vraiNomImage = $imagePayement->getClientOriginalName();
            $vraiNomResumer = $resumer->getClientOriginalName();

                $nouveauNomImage = $uploaderService->uploader($imagePayement);
                $nouveauNomResumer = $uploaderService->uploader($resumer);

                $user->setPassword($password)
                    ->setResumer($nouveauNomResumer)
                    ->setImagePayment($nouveauNomImage)
                    ->setResumerNouveauNom($vraiNomResumer)
                    ->setImagePayementNouveauNom($vraiNomImage)

                    ;
                $user->setPoster(0);


                    $entityManager->persist($user);
                    $entityManager->flush();
        
                    $this->addFlash(
                        'success',
                        'Vous avez reussi votre inscription'
                    );

                    return $this->redirectToRoute('inscription_success');

            }


            // encode the plain password


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

    #[Route('/inscription/success', name: 'inscription_success')]
    public function inscriptionSuccess(): Response
    {

        return $this->render('admin/inscription/success.html.twig', [
        ]);
    }
}
