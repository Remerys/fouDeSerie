<?php
namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Serie;
use App\Entity\WebSerie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SerieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //  for ($i=0;$i<5;$i++){
        //     $uneSerie= new Serie();
        //     $uneSerie->setTitre("titre$i");
        //     $uneSerie->setResume("resume$i");
        //     $uneSerie->setImage("image$i");
        //     $uneSerie->setLikes(0);
        //     $manager->persist($uneSerie);
        //     $manager->flush();
		//  }

        // choix de la langue des données
        $faker = Faker\Factory::create('fr_FR');
        // on créé 10 séries
        for ($i = 0; $i < 10; $i++) {
            $uneSerie = new Serie();
            $uneSerie->setTitre($faker->sentence(3, true)); // valoriser les autres propriétés en utilisant la documentation
            $uneSerie->setResume($faker->sentence(50, true));
            $uneSerie->setDuree($faker->time());
            $uneSerie->setPremiereDiffusion($faker->dateTimeBetween());
            $uneSerie->setImage($faker->imageUrl(640, 480, 'series', true));
            $uneSerie->setLikes($faker->randomNumber(2));
            $manager->persist($uneSerie);
            $manager->flush();
        }
    }
}