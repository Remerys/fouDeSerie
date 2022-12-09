<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Genre;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\GenreType;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminGenreController extends AbstractController
{
    #[Route('/admin/genres', name: 'app_admin_addGenre')]
    public function addGenre(Request $request, ManagerRegistry $doctrine): Response
    {
        $genre = new Genre();
        $form=$this->createForm(GenreType::class, $genre); 
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager=$doctrine->getManager();
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('app_series');
        }

        return $this->render('admin_genre/addGenre.html.twig', ['form' => $form->createView(),]);
    }

    #[Route('/admin/genres/{id}', name: 'app_admin_updateGenre')]
    public function updateGenre(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(Genre::class);
        $leGenre = $repository->find($id);
        if ($leGenre !== null) {
            $updateForm=$this->createForm(GenreType::class, $leGenre); 
            $updateForm->handleRequest($request);
            if($updateForm->isSubmitted() && $updateForm->isValid()) {
                $entityManager=$doctrine->getManager();
                $entityManager->persist($leGenre);
                $entityManager->flush();
    
                return $this->redirectToRoute('app_series');
            }
            return $this->render('admin_genre/addGenre.html.twig', ['form' => $updateForm->createView(),]);
        } else {
            return new JsonResponse(['message' => 'Genre not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
