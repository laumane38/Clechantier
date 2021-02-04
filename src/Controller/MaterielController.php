<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MaterielController extends AbstractController
{

    /**
     * @Route("/indexMateriel", name="indexMateriel")
     */
    public function index(): Response
    {
        return $this->render('pages/materiel.html.twig');
    }
}
