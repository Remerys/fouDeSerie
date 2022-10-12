<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PdoFouDeSerie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    #[Route('/api/series', name: 'app_api_series', methods: ['GET'])]
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

    #[Route('/api/series/{id}', name: 'app_api_serie_id', methods: ['GET'])]
    public function getLaSerie(PdoFouDeSerie $pdoFouDeSerie, $id): Response
    {
        $laSerie = $pdoFouDeSerie->getLaSerie($id);
        if ($laSerie !== false) {
            $tableau = [
                'id'=>$laSerie['id'],
                'titre'=>$laSerie['titre'],
                'resume'=>$laSerie['resume'],
                'duree'=>$laSerie['duree'],
                'premiereDiffusion'=>$laSerie['premiereDiffusion'],
                'image'=>$laSerie['image']
            ];
            return new JsonResponse($tableau);
        } else {
            return new JsonResponse(['message' => 'Serie not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/api/series', name: 'app_api_newSerie', methods: ['POST'])]
    public function newSerie(Request $request, PdoFouDeSerie $pdoFouDeSerie)
    {
        $content = $request->getContent();
        if (!empty($content)) {
            $laSerie = json_decode($content, true);
            $laSerieAjoutee = $pdoFouDeSerie->setLaSerie($laSerie);
            $tableau = [
                'id'=>$laSerieAjoutee['id'],
                'titre'=>$laSerieAjoutee['titre'],
                'resume'=>$laSerieAjoutee['resume'],
                'duree'=>$laSerieAjoutee['duree'],
                'premiereDiffusion'=>$laSerieAjoutee['premiereDiffusion'],
                'image'=>$laSerieAjoutee['image']
            ];
        }

        return new JsonResponse($tableau, Response::HTTP_CREATED);
    }

    #[Route('/api/series/{id}', name: 'app_api_deleteSerie_id', methods: ['DELETE'])]
    public function deleteSerie($id, PdoFouDeSerie $pdoFouDeSerie) {
        $laSerie = $pdoFouDeSerie->getLaSerie($id);
        if ($laSerie !== false) {
            $pdoFouDeSerie->deleteLaSerie($id);

            return new JsonResponse('La ressource a été supprimé', Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse(['message' => 'Serie not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/api/series/{id}', name: 'app_api_updateSerie_id', methods: ['PUT'])]
    public function updateSerieComplete(Request $request, $id, PdoFouDeSerie $pdoFouDeSerie) {
        $laSerie = $pdoFouDeSerie->getLaSerie($id);
        $content = $request->getContent();
        if ($laSerie !== false) {
            $laSerie = json_decode($content, true);
            $laSerieModifiee = $pdoFouDeSerie->updateLaSerie($laSerie, $id);
            $tableau = [
                'id'=>$laSerieModifiee['id'],
                'titre'=>$laSerieModifiee['titre'],
                'resume'=>$laSerieModifiee['resume'],
                'duree'=>$laSerieModifiee['duree'],
                'premiereDiffusion'=>$laSerieModifiee['premiereDiffusion'],
                'image'=>$laSerieModifiee['image']
            ];
            return new JsonResponse($tableau, Response::HTTP_OK);
        } else {
            return new JsonResponse(['message' => 'Serie not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
