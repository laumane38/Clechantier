<?php

namespace App\DataFixtures;

use App\Entity\Membre;
use App\Entity\Nav;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @class appFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 50; $i++) {

            $membre = new Membre();

            $membre->setEmail("mail" . $i . "@test.dev");
            $membre->setNom("nom" . $i);
            $membre->setPassword(md5("password" . $i));
            $membre->setPrenom("prenom" . $i);

            $manager->persist($membre);
        }

        $manager->flush();
    }
}
