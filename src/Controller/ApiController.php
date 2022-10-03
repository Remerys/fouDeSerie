<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PdoFouDeSerie;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    #[Route('/api/series', name: 'app_api')]
    public function getListeSeries(PdoFouDeSerie $pdoFouDeSerie): Response
    {
        $lesSeries = $pdoFouDeSerie->getLesSeries();
        $tableau= [];
        foreach($lesSeries as $uneSerie) {
            $tableau[]=[
                'id'=>$uneSerie['id'],
                'titre'=>$uneSerie['titre'],
                'resume'=>$uneSerie['resume'],
                'duree'=>$uneSerie['duree'],
                'premiereDiffusion'=>$uneSerie['premiereDiffusion'],
                'image'=>$uneSerie['image']
            ];
        }
        return new JsonResponse($tableau);
    }
}
