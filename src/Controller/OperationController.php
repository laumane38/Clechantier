<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Operation;
use App\Form\OperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Require ROLE_USER for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 * 
 * @@Route("/article")
 */
class OperationController extends AbstractController
{

    /**
     * @Route("/addOperation/{id}", name="addOperation")
     */
    public function naddOperation($id, Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $operation = new Operation();

        $formNewOperation = $this->createForm(OperationType::class, $operation);

        return $this->render('pages/operation/addOperation.html.twig', [
            'articleId' => $id,
            'user' => $user,
            'formNewOperation' => $formNewOperation->createView()
            ]
        );
    }


}
