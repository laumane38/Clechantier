<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\ConnexionType;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class MembreController extends AbstractController
{

    /**
     * @Route("membre", name="index_membre")
     */
    public function index(Request $request): Response
    {
        $membre = new Membre();
        $formConnexion = $this->createForm(ConnexionType::class, $membre)->handleRequest($request);
        if ($formConnexion->isSubmitted() && $formConnexion->isValid()) {

            //$enregistrements = $this->getDoctrine()->getRepository(Membre::class)->find()

        }

        $formInscription = $this->createForm(InscriptionType::class, $membre)->handleRequest($request);
        if ($formInscription->isSubmitted() && $formInscription->isValid()) {

            //$enregistrements = $this->getDoctrine()->getRepository(Membre::class)->find()

        }

        return $this->render('pages/membre.html.twig', [
            'formConnexion' => $formConnexion->createView(),
            'formInscription' => $formInscription->createView()
        ]);
    }

    /**
     * @Route("membre/{id}", name="edition_membre")
     */
    public function edition(Membre $membre)
    {

        return $this->render('pages/membreEdition.html.twig', [
            'membre' => $membre
        ]);
    }
}
