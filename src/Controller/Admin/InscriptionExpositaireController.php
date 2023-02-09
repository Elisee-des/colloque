<?php

namespace App\Controller\Admin;

use App\Entity\Expositaire;
use App\Entity\User;
use App\Form\Admin\InscriptionExpositaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionExpositaireController extends AbstractController
{
    #[Route('/inscription/expositaire', name: 'inscription_expositaire')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $expositaire = new Expositaire();

        $form = $this->createForm(InscriptionExpositaireType::class, $expositaire);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $nom = $request->get("inscription_expositaire")["nom"];
            $prenom = $request->get("inscription_expositaire")["prenom"];
            $email = $request->get("inscription_expositaire")["email"];
            $structure = $request->get("inscription_expositaire")["structure"];
            $emailStructure = $request->get("inscription_expositaire")["emailStructure"];
            $produits = $request->get("inscription_expositaire")["produits"];
        }

        $expositaire->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
            ->setStructure($structure)
            ->setEmailStructure($emailStructure)
            ->setProduits($produits);

        $em->persist($expositaire);
        $em->flush();

        $this->addFlash(
           'success',
           'Vous etes inscript en tant que expositaire au colloque.'
        );

        return $this->redirectToRoute('admin_dashboard');

        return $this->render('admin/inscription_expositaire/index.html.twig', [
            'formulaireInscription' => $form->createView()
        ]);
    }
}
