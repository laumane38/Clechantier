<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LevageController extends AbstractController
{

    /**
     * @Route("/levage", name="index_levage")
     */
    public function index(): Response
    {
        return $this->render('pages/levage.html.twig');
    }
}
