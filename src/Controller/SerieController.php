<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service;
use App\Service\PdoFouDeSerie;

class SerieController extends AbstractController
{
    #[Route('/series', name: 'app_series')]
    public function series(PdoFouDeSerie $pdoFouDeSerie): Response
    {
        $lesSeries = $pdoFouDeSerie->getLesSeries();
        $nombreSeries = $pdoFouDeSerie->getNbSeries();
        return $this->render('series/index.html.twig', ['lesSeries'=> $lesSeries, 'nombreSeries' => $nombreSeries]);
    }
}
