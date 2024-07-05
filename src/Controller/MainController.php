<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\FormObject\SearchSortieObject;
use App\Form\SearchSortieFormType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(Request $request, EntityManagerInterface $entityManager, CampusRepository $campusRepository): Response
    {
        $campuses = $campusRepository->findAllAsChoices();

        //$campus = new Campus();
        //$form = $this->createForm(SearchSortieFormType::class, $campus);
        $searchSortieObject = new SearchSortieObject();
        $form = $this->createForm(SearchSortieFormType::class, $searchSortieObject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$selectedCampus = $form->get('campus')->getData();
            //$entityManager->persist($campuses);
            //->flush();

            $selectedCampus = $searchSortieObject->getCampus();
            return $this->redirectToRoute('main_home');
        }

        return $this->render('main/home.html.twig', [
            'form' => $form->createView(),
            'campuses' => $campuses,
        ]);
    }
}