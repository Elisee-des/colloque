<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\editionCompteInscriptionType;
use App\Form\Admin\editionPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Nzo\FileDownloaderBundle\FileDownloader\FileDownloader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Route('/admin', name: 'admin_')]
class UserController extends AbstractController
{
    private $fichierATelecharger;

    public function __construct(FileDownloader $fichierATelecharger)
    {
        $this->fichierATelecharger = $fichierATelecharger;
        
    }

    #[Route('/liste/inscriptions', name: 'liste_inscription')]
    public function index(UserRepository $userRepository): Response
    {


        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/liste/detail/inscrit/{id}', name: 'user_detail')]
    public function detailUser(UserRepository $userRepository, User $user): Response
    {

        return $this->render('admin/user/detailInscript.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/inscription/edition/{id}', name: 'user_edition')]
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

    
    #[Route('/inscriptions/telecharger', name: 'telecharger_liste_users')]
    public function telecharger(UserRepository $userRepository, Request $request): Response
    {
        if (isset($_POST["export"])) {
            $type_fichier = $request->get("file_type");

            $inscrits = $userRepository->findAll();

            $fichier = new Spreadsheet();

            $active_feuille = $fichier->getActiveSheet();

            $active_feuille->setCellValue("A1", "Noms");
            $active_feuille->setCellValue("B1", "Prenoms");
            $active_feuille->setCellValue("C1", "Contacts");

            $count = 2;

            foreach ($inscrits as $inscrit) {
                    $active_feuille->setCellValue("A" . $count, $inscrit->getNom());
                    $active_feuille->setCellValue("B" . $count, $inscrit->getPrenom());
                    $active_feuille->setCellValue("C" . $count, $inscrit->getContact());
    
                    $count = $count + 1;
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($fichier, $type_fichier);

            $nom_fichier = "liste de tout les inscripts sur le site" . '.' . strtolower($type_fichier);

            $writer->save($nom_fichier);

            header('Content-Type: application/x-www-form-urlencoded');

            header('Content-Transfer-Encoding: Binary');

            header("Content-disposition: attachment; filename=\"" . $nom_fichier . "\"");

            readfile($nom_fichier);

            unlink($nom_fichier);

            return $this->redirectToRoute('admin_liste_inscription');
        }
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
