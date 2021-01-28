<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_USER for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 */
class MembreController extends AbstractController
{

    /**
     * @Route("/membre", name="index_membre")
     */
    public function index(): Response
    {
        return $this->render('pages/membre.html.twig');
    }

    /**
     * @Route("/profilModify", name="profilModify")
     */
    public function profilModify(): Response
    {
        return $this->render('pages/profilModify.html.twig');
    }

}
