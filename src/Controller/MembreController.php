<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\User;
use App\Form\AdressType;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/adress", name="adress")
     */
    public function adress(Request $request): Response
    {

        $formAdress = $this->createForm(AdressType::class);

        if ($request->isMethod('POST')) {
            
            $formAdress->submit($request->request->get($formAdress->getName()));

            if($formAdress->isSubmitted())
            {

                $sub = $request->request->get('adress');

                if($sub['zipCode']==="") $sub['zipCode']= null;

                $user = $this->getUser();
                $entityManager = $this->getDoctrine()->getManager();

                $adress = new Adress;
                $adress->setIdProfil($user->getId());
                $adress->setAdressTitle($sub['adressTitle']);
                $adress->setGenderUser($sub['genderUser']);
                $adress->setFirstName($sub['firstName']);
                $adress->setLastName($sub['lastName']);
                $adress->setCompanie($sub['companie']);
                $adress->setAdress($sub['adress']);
                $adress->setAdress2($sub['adress2']);
                $adress->setAppartmentNumber($sub['appartmentNumber']);
                $adress->setFloor($sub['floor']);
                $adress->setZipCode($sub['zipCode']);
                $adress->setCity($sub['city']);
                $adress->setCountry($sub['country']);

                

                if($adress->getAdressTitle()!==""){

                    $entityManager->persist($adress);
                    $entityManager->flush();

                    $this->addFlash(
                        'success',
                        'Nouvelle adresse enregistrée avec succès'
                    );
                    
                }
                else{

                    $this->addFlash(
                        'alert',
                        'Donnez un titre à cette adresse'
                    );
                }

            }
        }

        return $this->render('pages/adress.html.twig',[
            'formAdress' => $formAdress->createView()
        ]);
    }

}
