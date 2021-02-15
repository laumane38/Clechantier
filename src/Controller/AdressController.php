<?php

namespace App\Controller;

use App\Entity\Adress;
use Doctrine\ORM\EntityManagerInterface;
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
class AdressController extends AbstractController
{

    /**
     * @Route("/delete/adress/{id}", name="adressDelete")
     */
    public function deleteAdress($id, EntityManagerInterface $em, request $request): Response
    {
        $user = $this->getUser();

        $repo = $em->getRepository(Adress::class);
        $adressToDisable = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id
        ],);

        if(!empty($adressToDisable)){

            $adressToDisable->setEnable(0);
            $adressToDisable->setDefaultAdress(0);
            $em->persist($adressToDisable);
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
     * @Route("/setDefault/adress/{id}", name="adressSetDefault")
     */
    public function setDefaultAdress($id, EntityManagerInterface $em, request $request): Response
    {

        $user = $this->getUser();

        $repo = $em->getRepository(Adress::class);
        $adressToSetDefault = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id,
            'defaultAdress'=>'0'

        ],);

        $adressToUnSetDefault = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'defaultAdress'=>'1'
        ],);



        if(!empty($adressToSetDefault)){

            $adressToSetDefault->setDefaultAdress(1);

            if(!empty($adressToUnSetDefault)){
                $adressToUnSetDefault->setDefaultAdress(0);
                $em->persist($adressToUnSetDefault);
            }

            $em->persist($adressToSetDefault);
            
            $em->flush();

            $this->addFlash(
                'success',
                'Votre adresse par défaut a bien été modifié.'
            );

        }
        else
        {

            $this->addFlash(
                'alert',
                'Il n\'y a rien à définir par défaut. Cet élément a déjà été modifié ou il ne vous appartient pas.'
            );
    
        }

        return $this->redirectToRoute('adress');
    }
}