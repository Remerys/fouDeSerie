<?php

namespace App\Controller;

use App\Entity\Serie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service;
use App\Service\PdoFouDeSerie;
use Doctrine\Persistence\ManagerRegistry;

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
            4
        );
        dump($lesSeries);
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

        return $this->render('series/info.html.twig', ['serie' => $laSerie]);
    }
}
