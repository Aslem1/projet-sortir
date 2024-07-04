<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil(Request $request, EntityManagerInterface $entityManager, CampusRepository $campusRepository): Response
    {
        $campuses = $campusRepository->findAllAsChoices();

        $participant = new Participant();

        $form = $this->createForm(RegistrationFormType::class, $participant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a bien été mis à jour');

            return $this->redirectToRoute('app_profil');
        }

        return $this->render('profil/monProfil.html.twig', [
            'form' => $form->createView(),
            'campuses' => $campuses,
        ]);
    }
}