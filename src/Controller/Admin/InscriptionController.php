<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\Admin\InscriptionType;
use App\Service\UploaderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_admin_inscription')]
    public function index(Request $request, EntityManagerInterface $em, UploaderService $uploaderService): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $communication = $request->get("communication");
            $resumer = $request->get("resume");
            $imagePayement = $request->get("imagePayement");
            $nouveauNom1 = $uploaderService->uploader($communication);
            $nouveauNom2 = $uploaderService->uploader($resumer);
            $nouveauNom3 = $uploaderService->uploader($imagePayement);
            $user->setCommunication($nouveauNom1);
            $user->setCommunication($nouveauNom2);
            $user->setCommunication($nouveauNom3);
            dd($user);
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'message',
                "Votre inscription a ete faite avec success."
            );

            return $this->redirectToRoute('admin_dashboard');

        }

        return $this->render('admin/inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }
}
