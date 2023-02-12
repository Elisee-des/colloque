<?php

namespace App\Controller\Admin;

use App\Entity\Expositaire;
use App\Entity\User;
use App\Form\Admin\editionExposantType;
use App\Repository\ExpositaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Path;

#[Route('/admin', name: 'admin_')]
class ExposantController extends AbstractController
{

    #[Route('/liste/inscription/exposant', name: 'liste_inscription_exposants')]
    public function index(ExpositaireRepository $exposantRepository): Response
    {

        return $this->render('admin/exposant/index.html.twig', [
            'exposants' => $exposantRepository->findAll(),
        ]);
    }

    #[Route('/exposant/detail/{id}', name: 'exposant_detail')]
    public function detailUser(Expositaire $exposant): Response
    {

        return $this->render('admin/exposant/detail.html.twig', [
            'exposant' => $exposant,
        ]);
    }

    #[Route('exposant/edition/{id}', name: 'edition_exposant')]
    public function edition(Expositaire $exposant, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(editionExposantType::class, $exposant);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $em->persist($exposant);
            $em->flush();

            $this->addFlash(
                'success',
                'Vous avez modifier avec succes les informations de cet inscription'
            );

            return $this->redirectToRoute('admin_exposant_detail', ["id"=> $exposant->getId()]);
            
        }

        return $this->render('admin/exposant/edition.html.twig', [
            'form' => $form->createView(),
            'exposant' => $exposant
        ]);
    }

    #[Route('/exposants/telecharger', name: 'telecharger_liste_exposants')]
    public function telecharger(ExpositaireRepository $expositaireRepository, Request $request): Response
    {
        if (isset($_POST["export"])) {
            $type_fichier = $request->get("file_type");

            $exposants = $expositaireRepository->findAll();

            $fichier = new Spreadsheet();

            $active_feuille = $fichier->getActiveSheet();

            $active_feuille->setCellValue("A1", "Noms");
            $active_feuille->setCellValue("B1", "Prenoms");
            $active_feuille->setCellValue("C1", "Contacts");
            $active_feuille->setCellValue("D1", "NomStructures");

            $count = 2;

            foreach ($exposants as $exposant) {
                    $active_feuille->setCellValue("A" . $count, $exposant->getNom());
                    $active_feuille->setCellValue("B" . $count, $exposant->getPrenom());
                    $active_feuille->setCellValue("C" . $count, $exposant->getContact());
                    $active_feuille->setCellValue("D" . $count, $exposant->getStructure());
    
                    $count = $count + 1;
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($fichier, $type_fichier);

            $nom_fichier = "liste des exposants" . '.' . strtolower($type_fichier);

            $writer->save($nom_fichier);

            header('Content-Type: application/x-www-form-urlencoded');

            header('Content-Transfer-Encoding: Binary');

            header("Content-disposition: attachment; filename=\"" . $nom_fichier . "\"");

            readfile($nom_fichier);

            unlink($nom_fichier);

            return $this->redirectToRoute('admin_liste_inscription_exposants');
        }
    }

 
}
