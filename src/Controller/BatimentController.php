<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BatimentController extends AbstractController
{

    /**
     * @Route("/indexBatiment", name="indexBatiment")
     */
    public function index(): Response
    {
        return $this->render('pages/batiment.html.twig');
    }
}
