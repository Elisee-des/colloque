<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\editionCompteInscriptionType;
use App\Form\Admin\editionPasswordType;
use App\Repository\ExpositaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

#[Route('/admin', name: 'admin_')]
class ExpositaireController extends AbstractController
{

    #[Route('/liste/inscription/expositaire', name: 'liste_inscription_expositaire')]
    public function index(ExpositaireRepository $expositaireRepository): Response
    {


        return $this->render('admin/expositaire/index.html.twig', [
            'expositaires' => $expositaireRepository->findAll(),
        ]);
    }

    #[Route('/liste/expositaire/inscript/{id}', name: 'expositaire_detail')]
    public function detailUser(UserRepository $userRepository, User $user): Response
    {

        return $this->render('admin/user/detailInscript.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('expositaire/edition/{id}', name: 'edition_expositaire')]
    public function edition(User $user, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordhasher): Response
    {
        $form = $this->createForm(editionCompteInscriptionType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec succes les informations de cet utilisateur'
            );

            return $this->redirectToRoute('admin_user_detail', ["id"=> $user->getId()]);
            
        }

        return $this->render('admin/user/editionCompteInscription.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/user/edition/motdepasse/{id}', name: 'user_edition_password')]
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

    #[Route('/telechargement/{communication}', name: 'telecharger')]
    public function telechargementFichier($communication, Request $request): Response
    {
        
    $filesystem = new Filesystem();

    try {
        $filesystem->mkdir(
            Path::normalize(sys_get_temp_dir().'/'.random_int(0, 1000)),
        );
    } catch (IOExceptionInterface $exception) {
        echo "An error occurred while creating your directory at ".$exception->getPath();
    }

    // dd($filesystem->ch);

    return $this->render('admin/user/editionPassword.html.twig', [
    ]);

    }
}
