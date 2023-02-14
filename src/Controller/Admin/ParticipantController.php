<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\EditionParticipantType;
use App\Form\Admin\editionPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class ParticipantController extends AbstractController
{
    #[Route('/participants', name: 'participant')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        foreach($users as $user)
        {
            $resumer = $user->getResume();
            if($resumer == '')
            {
                $participants[] = $user;
            }
        }

        return $this->render('admin/participant/index.html.twig', [
            'participants' => $participants,
        ]);
    }

    #[Route('/participants/detail/{id}', name: 'participant_detail')]
    public function detailUser(User $participant): Response
    {

        return $this->render('admin/participant/detail.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[Route('/participant/edition/{id}', name: 'edition_participant')]
    public function edition(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EditionParticipantType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec succes les informations de cet utilisateur'
            );

            return $this->redirectToRoute('admin_participant_detail', ["id"=> $user->getId()]);
            
        }

        return $this->render('admin/participant/edition.html.twig', [
            'form' => $form->createView(),
            'participant' => $user
        ]);
    }

    #[Route('/edition/motdepasse/{id}', name: 'user_edition_password')]
    public function editionPassword(User $user, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordhasher): Response
    {
        $form = $this->createForm(editionPasswordType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $passwordClaire = $request->get("edition_password")["password"]["first"];
            $password = $passwordhasher->hashPassword($user, $passwordClaire);
            
            $user->setPassword($password);
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous modifier avec success le mot de passe de cette utilisateur'
            );

            return $this->redirectToRoute('admin_user_detail', ["id"=> $user->getId()]);
            
        }

        return $this->render('admin/user/editionPassword.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    
    #[Route('/participants/telecharger', name: 'telecharger_liste_participants')]
    public function telecharger(UserRepository $userRepository, Request $request): Response
    {
        if (isset($_POST["export"])) {
            $type_fichier = $request->get("file_type");

            $participants = $userRepository->findAll();
            foreach($participants as $participant)
            {
                $resumer = $participant->getResume();
                if($resumer == '')
                {
                    $participants[] = $participant;
                }
            }

            $fichier = new Spreadsheet();

            $active_feuille = $fichier->getActiveSheet();

            $active_feuille->setCellValue("A1", "Noms");
            $active_feuille->setCellValue("B1", "Prenoms");
            $active_feuille->setCellValue("B1", "Contacts");

            $count = 2;

            foreach ($participants as $participant) {
                    $active_feuille->setCellValue("A" . $count, $participant->getNom());
                    $active_feuille->setCellValue("B" . $count, $participant->getPrenom());
                    $active_feuille->setCellValue("C" . $count, $participant->getContact());
    
                    $count = $count + 1;
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($fichier, $type_fichier);

            $nom_fichier = "liste des participants" . '.' . strtolower($type_fichier);

            $writer->save($nom_fichier);

            header('Content-Type: application/x-www-form-urlencoded');

            header('Content-Transfer-Encoding: Binary');

            header("Content-disposition: attachment; filename=\"" . $nom_fichier . "\"");

            readfile($nom_fichier);

            unlink($nom_fichier);

            return $this->redirectToRoute('admin_participant');
        }
    }

}
