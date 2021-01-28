<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VehiculeController extends AbstractController
{

    /**
     * @Route("/vehicule", name="index_vehicule")
     */
    public function index(): Response
    {
        return $this->render('pages/vehicule.html.twig');
    }
}
