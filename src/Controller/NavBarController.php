<?php

namespace App\Controller;

use App\Entity\Heading;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;


class NavBarController extends AbstractController
{
    public function navBar(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Heading::class);

        $items = $repo->findAll();

        return $this->render('_navBar.html.twig', [
            'items' => $items
        ]);
    }
}