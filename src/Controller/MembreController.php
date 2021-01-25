<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MembreController extends AbstractController
{

    /**
     * @Route("/membre", name="index_membre")
     */
    public function index(): Response
    {
        return $this->render('pages/membre.html.twig');
    }
}
