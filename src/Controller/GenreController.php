<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Serie;
use App\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;

class GenreController extends AbstractController
{
    #[Route('/testGenre', name: 'app_testGenre')]
    public function testGenre(ManagerRegistry $doctrine): Response
    {
        $genre = new Genre();
        $genre->setlibelle('Policier');

        $entityManager=$doctrine->getManager();
        $entityManager->persist($genre);

        $repository = $doctrine->getRepository(Serie::class);
        $laSerie = $repository->find(1);
        $laSerie->addGenre($genre);

        $entityManager->flush();

        return $this->render('genre/index.html.twig', ['serie' => $laSerie]);
    }
}
