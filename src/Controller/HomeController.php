<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service;
use App\Service\PdoFouDeSerie;
use App\Entity\Serie;
use Doctrine\Persistence\ManagerRegistry;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/news', name: 'app_news')]
    public function news(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Serie::class);
        $lesSeries = $repository->findBy(
            [],
            ['titre' => 'DESC'],
            4
        );

        return $this->render('news/index.html.twig', ['lesSeries'=> $lesSeries]);
    }

    #[Route('/testEntity', name: 'app_testEntity')]
    public function testEntity(ManagerRegistry $doctrine): Response
    {
        $serie = new Serie();
        $serie->setTitre('truc');
        $serie->setResume('');
        $serie->setDuree('00:30:00');
        $serie->setPremiereDiffusion(new \DateTime('01-09-2022'));

        $entityManager=$doctrine->getManager();
        $entityManager->persist($serie);
        $entityManager->flush();

        return $this->render('home/testEntity.html.twig', ['lesSeries' => $serie]);
    }
    
}
