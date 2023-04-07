<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class PosterController extends AbstractController
{
    #[Route('/posters', name: 'poster')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/poster/index.html.twig', [
            'posters' => $users,
        ]);
    }

    #[Route('/posters/telecharger', name: 'telecharger_liste_posters')]
    public function telecharger(UserRepository $userRepository, Request $request): Response
    {
        if (isset($_POST["export"])) {
            $type_fichier = $request->get("file_type");

            $posters = $userRepository->findAll();

            $fichier = new Spreadsheet();

            $active_feuille = $fichier->getActiveSheet();

            $active_feuille->setCellValue("A1", "Noms");
            $active_feuille->setCellValue("B1", "Prenoms");
            $active_feuille->setCellValue("C1", "Contacts");

            $count = 2;

            foreach ($posters as $poster) {
                    $active_feuille->setCellValue("A" . $count, $poster->getNom());
                    $active_feuille->setCellValue("B" . $count, $poster->getPrenom());
                    $active_feuille->setCellValue("C" . $count, $poster->getContact());
    
                    $count = $count + 1;
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($fichier, $type_fichier);

            $nom_fichier = "liste des posters" . '.' . strtolower($type_fichier);

            $writer->save($nom_fichier);

            header('Content-Type: application/x-www-form-urlencoded');

            header('Content-Transfer-Encoding: Binary');

            header("Content-disposition: attachment; filename=\"" . $nom_fichier . "\"");

            readfile($nom_fichier);

            unlink($nom_fichier);

            return $this->redirectToRoute('admin_poster');
        }
    }
}
