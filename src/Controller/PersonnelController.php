<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonnelController extends AbstractController
{

    /**
     * @Route("/personnel", name="index_personnel")
     */
    public function index(): Response
    {
        return $this->render('pages/personnel.html.twig');
    }
}
