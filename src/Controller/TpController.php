<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TpController extends AbstractController
{

    /**
     * @Route("/indexTp", name="indexTp")
     */
    public function index(): Response
    {
        return $this->render('pages/tp.html.twig');
    }
}
