<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\InscriptionType;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'admin_inscription')]
    public function index(Request $request, EntityManagerInterface $em, UploaderService $uploaderService, UserPasswordHasherInterface $passwordhasher): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);


        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $passwordClaire = $request->get("inscription")["password"]["first"];
            $password = $passwordhasher->hashPassword($user, $passwordClaire);
            $communication = $form->get("communicationFile")->getData();
            $resumer = $form->get("resumeFile")->getData();
            $imagePayement = $form->get("imagePayementFile")->getData();
            $nouveauNom1 = $uploaderService->uploader($communication);
            $nouveauNom2 = $uploaderService->uploader($resumer);
            $nouveauNom3 = $uploaderService->uploader($imagePayement);
            
            $user
            ->setPassword($password)
            ->setCommunication($nouveauNom1)
            ->setResume($nouveauNom2)
            ->setImagePayement($nouveauNom3)
            ->setTerms(true)
            ->setAPayer(false);
            
                $this->addFlash(
                    'success',
                    'Vous avez reussi votre inscription'
                 );

            return $this->redirectToRoute('admin_dashboard');


            $em->persist($user);
            $em->flush();
        }
        
        // if (isset($_POST["inscription"])) {
            
        //     $nom = $request->get("nom");
        //     $prenom = $request->get("prenom");
        //     $email = $request->get("email");
        //     $password = $request->get("password");
        //     $communication = $request->get("communication");
        //     $resumer = $request->get("resumer");
        //     $imagePayement = $request->get("imagePayement");
        //     $terms = $request->get("terms");

        //     // dd($nom, $prenom, $email, $password, $communication, $resumer, $imagePayement, $terms);
            
            
            // $nouveauNom1 = $uploaderService->uploader($communication);
            // dd($nouveauNom1);
            // $nouveauNom2 = $uploaderService->uploader($resumer);
            // $nouveauNom3 = $uploaderService->uploader($imagePayement);

            // $user->setNom($nom)
            //     ->setPrenom($prenom)
            //     ->setEmail($email)
            //     ->setPassword($password)
            //     ->setCommunication($nouveauNom1)
            //     ->setResume($nouveauNom2)
            //     ->setImagePayement($nouveauNom3)
            //     ->setTerms($terms);

            //     $this->addFlash(
            //         'success',
            //         'Vous avez reussi votre inscription'
            //      );

            // $em->persist($user);
            // $em->flush();

        //     $this->addFlash(
        //         'message',
        //         "Votre inscription a ete faite avec success."
        //     );

            // return $this->redirectToRoute('admin_dashboard');

        // }

        return $this->render('admin/inscription/index.html.twig', [
            'formulaireInscription' => $form->createView(),
        ]);
    }
}
