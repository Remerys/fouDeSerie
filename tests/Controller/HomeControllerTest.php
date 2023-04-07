<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testH1HomePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $nb = $crawler->filter('h1:contains("Promis, après cet épisode j\'arrête!!")')->count();
        $this->assertEquals(1, $nb);
    }
}