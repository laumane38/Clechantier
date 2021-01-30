<?php

namespace App\Controller;

use App\Entity\Adress;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AdressType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdressController extends AbstractController
{

    /**
     * @Route("/supprimer/adress/{id}", name="delete_adress")
     */
    public function deleteAdress($id, EntityManagerInterface $em, request $request): Response
    {
        $user = $this->getUser();

        $repo = $em->getRepository(Adress::class);
        $adressToDisable = $repo->findBy([
            'idProfil' => $user->getId(),
            'enable' => '1',
            'id' => $id
        ],);

        if(!empty($adressToDisable[0])){

            $adressToDisable[0]->setEnable(0);
            $adressToDisable[0]->setDefaultAdress(0);
            $em->persist($adressToDisable[0]);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre adresse a bien été supprimé.'
            );

        }
        else{

        $this->addFlash(
            'alert',
            'Il n\'y a rien à supprimer. Cet élément a déjà été supprimé ou il ne vous appartient pas.'
        );

        }

        return $this->redirectToRoute('adress');
    
    }

    /**
     * @Route("/setDefault/adress/{id}", name="set_default_adress")
     */
    public function setDefaultAdress($id, EntityManagerInterface $em, request $request): Response
    {

        $user = $this->getUser();

        $repo = $em->getRepository(Adress::class);
        $adressToSetDefault = $repo->findBy([
            'idProfil' => $user->getId(),
            'enable' => '1',
            'id' => $id,
            'defaultAdress'=>'0'

        ],);

        $adressToUnSetDefault = $repo->findBy([
            'idProfil' => $user->getId(),
            'enable' => '1',
            'defaultAdress'=>'1'
        ],);



        if(!empty($adressToSetDefault[0])){

            $adressToSetDefault[0]->setDefaultAdress(1);

            if(!empty($adressToUnSetDefault[0])){
                $adressToUnSetDefault[0]->setDefaultAdress(0);
                $em->persist($adressToUnSetDefault[0]);
            }

            $em->persist($adressToSetDefault[0]);
            
            $em->flush();

            $this->addFlash(
                'success',
                'Votre adresse par défaut a bien été modifié.'
            );

        }
        else{

            $this->addFlash(
                'alert',
                'Il n\'y a rien à définir par défaut. Cet élément a déjà été modifié ou il ne vous appartient pas.'
            );
    
            }

        return $this->redirectToRoute('adress');
    }
}