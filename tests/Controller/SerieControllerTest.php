<?php

namespace App\Tests\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SerieControllerTest extends WebTestCase
{
    /**
    * @dataProvider provideUrls
    */
    public function testShowSerieIsUp($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function provideUrls()
    {
        return array(
            array('/'),
            array('/news'),
            array('/series'),
            array('/admin/series'),
            array('/admin/series/all'),
            array('/admin/genres')
        );
    }

    public function testAddSerie()
    {
        $client = static::createClient();
        //récupération du nombre de séries avant l'ajout
        $nb1 = self::getContainer()->get(SerieRepository::class)->count([]);
        dump($nb1);
        //récupération du crawler qui liste les séries
        $crawlerListe = $client->request('GET','/admin/series/all');
        //récupération du nombre de p avec Test Nouveau Titre avant l'ajout
        $nbPAvant = $crawlerListe->filter('li:contains("Test Nouveau Titre")')->count();
        //récupération du crawler correspondant à la page contenant le  formulaire
        $crawler = $client->request('GET', '/admin/series');
        $form = $crawler->selectButton('btnSave')->form();
        // Les contrôles graphiques du formulaire ont été automatiquement générées par symfony grâce à twig. Il est donc utile d'aller voir le code source pour trouver le nom des contrôles graphiques
        $form['serie[titre]'] = 'Test Nouveau Titre ';
        $form['serie[resume]'] ='Test Nouveau resume ';
        $client->submit($form);
        // on s'attend à ce qu'il y ait une redirection vers la page /admin/series/all
        $this->assertResponseRedirects('/series');
        // on s'attend à ce que la réponse ait le statut 200
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        //on demande à suivre la redirection et on récupère le nouveau crawler correspondant à la nouvelle page (ici la page listant les séries)
        $crawler = $client->followRedirect();
        // on s'attend qu'il y ait une balise li supplémentaire par rapport au départ avec le titre
        $this->assertEquals($nbPAvant+1, $crawler->filter('li:contains("Test Nouveau Titre")')->count());
        $nb2 = self::getContainer()->get(SerieRepository::class)->count([]);
        dump($nb2);
        $this->assertEquals($nb1+1, $nb2);
    }
}
