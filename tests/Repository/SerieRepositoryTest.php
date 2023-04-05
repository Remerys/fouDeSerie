<?php

namespace app\Tests\Repository;

use App\Entity\Serie;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Repository\SerieRepository;


class SerieRepositoryTest extends KernelTestCase
{
    // public function testCountSerie()
    // {
    //     self::bootKernel();
    //     $nb = self::getContainer()->get(SerieRepository::class)->count([]);
    //     $this->assertEquals(10, $nb);
    // }

    public function testIsNewSerie()
    {
        self::bootKernel();
        $series = self::getContainer()->get(SerieRepository::class)->findAll();
        foreach ($series as $serie) {
            $bool = $serie->isNewSerie();
            $this->assertEquals(true, $bool);
        }
    }
}
