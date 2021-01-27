<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 50; $i++) {

            $user = new User();
            $date = new DateTimeImmutable();

            $roles[] = 'ROLE_USER';

            $user->setPseudo("login" . $i);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, "password"));
            $user->setRoles(array_unique($roles));
            $user->setEmail("email@email.com");

            $user->setConnectedAt($date);
            $user->setRegisteredAt($date);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
