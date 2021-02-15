<?php

namespace App\DataFixtures;

use App\Entity\RentalType;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RentalTypeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $items = array(
            array(
                'name' => 'à la journée'
            ),
            array(
                'name' => 'à la semaine'
            ),
            array(
                'name' => 'au mois'
            ),
            array(
                'name' => 'au trimestre'
            ),
            array(
                'name' => 'à l\'année'
            )
        );

        foreach ($items as $item){

        $rt = new RentalTYpe();
        $rt->setName($item['name']);
        $manager->persist($rt);

        }

        $manager->flush();
    }
}
