<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Form\SerieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends AbstractController
{
    #[Route('/admin/series', name: 'app_admin_addSerie')]
    public function addSerie(Request $request, ManagerRegistry $doctrine): Response
    {
        $serie = new Serie();
        $form=$this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager=$doctrine->getManager();
            $serie->setLikes(0);
            $entityManager->persist($serie);
            $entityManager->flush();

            return $this->redirectToRoute('app_series');
        }

        return $this->render('admin/addSerie.html.twig', ['form' => $form->createView(),]);
    }

    #[Route('/admin/series/all', name: 'app_admin_series')]
    public function adminSeries(ManagerRegistry $doctrine) {
        $repository = $doctrine->getRepository(Serie::class);
        $lesSeries = $repository->findBy(
            [],
            ['premiereDiffusion' => 'DESC'],
            // Modifie le nombre max de série affiché --> 4
        );
        $nombreSeries = count($lesSeries);

        return $this->render('admin/deleteSerie.html.twig', ['lesSeries'=> $lesSeries, 'nombreSeries' => $nombreSeries]);
    }

    #[Route('/admin/series/{id}', name: 'app_admin_deleteSerie', methods: 'DELETE')]
    public function deleteSerie(Request $request, ManagerRegistry $doctrine, $id) {
        $repository = $doctrine->getRepository(Serie::class);
        $laSerie = $repository->find($id);
        if ($laSerie !== null) {
            $token= $request->get('token');
            if ($this->isCsrfTokenValid('deleteSerie', $token)) {
                $entityManager=$doctrine->getManager();
                $entityManager->remove($laSerie);
                $entityManager->flush();

                return $this->redirectToRoute('app_admin_series');
            }
        } else {
            return new JsonResponse(['message' => 'Serie not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/admin/series/{id}', name: 'app_admin_updateSerie')]
    public function updateSerie(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(Serie::class);
        $laSerie = $repository->find($id);
        if ($laSerie !== null) {
            $updateForm=$this->createForm(SerieType::class, $laSerie, ['method' => 'PUT']);
            $updateForm->handleRequest($request);
            if($updateForm->isSubmitted() && $updateForm->isValid()) {
                $entityManager=$doctrine->getManager();
                $entityManager->persist($laSerie);
                $entityManager->flush();

                return $this->redirectToRoute('app_series');
            }
            return $this->render('admin/addSerie.html.twig', ['form' => $updateForm->createView(),]);
        } else {
            return new JsonResponse(['message' => 'Serie not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
