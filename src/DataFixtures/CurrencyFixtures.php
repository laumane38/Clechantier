<?php

namespace App\DataFixtures;

use App\Entity\Currency;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $items = array(
            array(
                'name' => 'EUR'
            ),
            array(
                'name' => 'USD'
            )
        );

        foreach ($items as $item){

        $currency = new Currency();
        $currency->setName($item['name']);
        $manager->persist($currency);

        }

        $manager->flush();
    }
}
