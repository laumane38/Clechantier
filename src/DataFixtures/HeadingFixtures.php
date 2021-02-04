<?php

namespace App\DataFixtures;

use App\Entity\Heading;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HeadingFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $items = array(
            array(
                'path' => 'indexMateriel',
                'name' => 'Matériel'
            ),
            array(
                'path' => 'indexLevage',
                'name' => 'Levage'
            ),
            array(
                'path' => 'indexBatiment',
                'name' => 'Batiment'
            ),
            array(
                'path' => 'indexTp',
                'name' => 'Travaux publics'
            ),
            array(
                'path' => 'indexVehicule',
                'name' => 'Véhicule'
            ),
            array(
                'path' => 'indexPersonnel',
                'name' => 'Personnel'
            )
        );

        foreach ($items as $item){

        $heading = new Heading();
        $heading->setName($item['name']);
        $heading->setPath($item['path']);
        $manager->persist($heading);

        }

        $manager->flush();
    }
}
