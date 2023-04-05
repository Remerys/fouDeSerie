<?php

namespace App\Controller;

use App\Entity\Serie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service;
use App\Service\PdoFouDeSerie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SerieController extends AbstractController
{
    #[Route('/series', name: 'app_series')]
    public function series(ManagerRegistry $doctrine) {
        $repository = $doctrine->getRepository(Serie::class);
        // $lesSeries = $repository->findAll();
        // $lesSeries = $repository->findBy(
        //     [],
        //     ['titre' => 'ASC']
        // );
        $lesSeries = $repository->findBy(
            [],
            ['premiereDiffusion' => 'DESC'],
            // Modifie le nombre max de série affiché --> 4
        );
        $nombreSeries = count($lesSeries);

        return $this->render('series/index.html.twig', ['lesSeries'=> $lesSeries, 'nombreSeries' => $nombreSeries]);
    }
    // public function series(PdoFouDeSerie $pdoFouDeSerie): Response
    // {
    //     $lesSeries = $pdoFouDeSerie->getLesSeries();
    //     $nombreSeries = $pdoFouDeSerie->getNbSeries();
    //     return $this->render('series/index.html.twig', ['lesSeries'=> $lesSeries, 'nombreSeries' => $nombreSeries]);
    // }

    #[Route('/series/{id}', name: 'app_seriesDetails')]
    public function details(ManagerRegistry $doctrine, $id) {
        $repository = $doctrine->getRepository(Serie::class);
        $laSerie = $repository->find($id);
        if (!$laSerie) {
            throw $this->createNotFoundException('La série n\'existe pas');
        }

        return $this->render('series/info.html.twig', ['serie' => $laSerie]);
    }

    #[Route('/series/{id}/like', name: 'app_seriesLikes')]
    public function getLikeOneSerie(ManagerRegistry $doctrine, $id, EntityManagerInterface $entityManager) {
        $repository = $doctrine->getRepository(Serie::class);
        $laSerie = $repository->find($id);

        try {
            if (!$laSerie) {
                throw $this->createNotFoundException("La série n'existe pas");
            }
            $likes = $laSerie->getLikes(); // Récupère le nombre de like avant
            $laSerie->setLikes($likes + 1); // Ajoute 1 like
            $entityManager->persist($laSerie); // Changement dans la BDD
            $entityManager->flush(); // Changement dans la BDD

            $likes = $laSerie->getLikes(); // Récupère le nombre de like après
            return new JsonResponse(['likes' => $likes]);
        } catch (NotFoundHttpException $th) {
            return new JsonResponse($th->getMessage() . ' code de statut : ' . $th->getStatusCode(), Response::HTTP_NOT_FOUND);
        }
    }
}
