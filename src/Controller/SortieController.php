<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Form\CreateSortieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie', name: 'app_sortie')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = new Sortie();
        $lieu = new Lieu();

        //$form = $this->createForm(CreateSortieFormType::class, $sortie);
        $form = $this->createForm(CreateSortieFormType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->addFlash('success', 'La sortie a bien été créée');

            return $this->redirectToRoute('main_home');
        }

        return $this->render('sorties/createSortie.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'SortieController',
        ]);
    }
}
