<?php

namespace App\DataFixtures;

use App\Entity\Heading;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HeadingFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {


        $items = array("Matériel","Levage","Batiment","Travaux publics","Véhicule","Personnel");

        foreach ($items as $item){

        $heading = new Heading();
        $heading->setName($item);
        $manager->persist($heading);

        }

        $manager->flush();
    }
}
