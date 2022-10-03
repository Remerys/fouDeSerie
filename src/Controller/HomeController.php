<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service;
use App\Service\PdoFouDeSerie;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    #[Route('/news', name: 'app_news')]
    public function news(): Response
    {
        return $this->render('news/index.html.twig');
    }
    
}
