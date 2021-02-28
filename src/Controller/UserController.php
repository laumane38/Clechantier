<?php

namespace App\Controller;

use App\Entity\User;

use App\Repository\UserRepository;

use App\Entity\Adress;
use App\Form\AdressType;
use App\Form\AvatarType;
use App\Form\ProfilType;
use App\Entity\OptionList;
use App\Entity\OperationList;
use App\Form\OptionListAddType;
use App\Form\OperationListAddType;
use App\Form\SearchCollaboraterType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Require ROLE_USER for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 * 
 * @@Route("/user")
 */
class UserController extends AbstractController
{
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @Route("/index", name="index_membre")
     */
    public function index(): Response
    {
        return $this->render('pages/user/index.html.twig');
    }

    /**
     * @Route("/profilModify", name="profilModify")
     */
    public function profilModify(): Response
    {
        return $this->render('pages/user/profilModify.html.twig');
    }

    /**
     * @Route("/adress", name="adress")
     */
    public function adress(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $adress = new Adress;

        $formAdress = $this->createForm(AdressType::class, $adress);
        $formAdress->handleRequest($request);

        if ($formAdress->isSubmitted() && $formAdress->isValid())
        {

            $sub = $request->request->get('adress');

            //si le code postal n'est pas renseigné on donne une valeur null pour que le code postal existe
            if($sub['zipCode']==="") $sub['zipCode']= null;

            //si l'adresse n'est pas défini par defaut on lui donne valeur 0
            //sinon on ne modife pas sa valeur mais on modifie la base de données pour que l'ancienne adresse par defaut ne le soit plus
            if(empty($sub['defaultAdress'])){
                $sub['defaultAdress'] = 0;
            }
            else{

                $repo = $em->getRepository(Adress::class);
                $adressToSetNotDefault = $repo->findOneBy([
                    'user' => $user,
                    'enable' => '1',
                    'defaultAdress' => '1'
                ]);
                
                if(!empty($adressToSetNotDefault))
                {
                    $adressToSetNotDefault->setDefaultAdress(0);

                    $em->persist($adressToSetNotDefault);
                    $em->flush();
                }
            }

            $adress->setUser($user);
            $adress->setEnable(1);
            

            if($adress->getAdressTitle()!==""){

                $em->persist($adress);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Nouvelle adresse enregistrée avec succès.'
                );

                return $this->redirectToRoute('adress');
                
            }
            else{

                $this->addFlash(
                    'alert',
                    'Donnez un titre à cette adresse.'
                );
            }

        }
        

        $repo = $em->getRepository(Adress::class);
        $adress = $repo->findBy([
            'user' => $user,
            'enable' => '1'
        ],[
            'defaultAdress'=>'DESC',
            'id' => 'DESC'
        ]);

        return $this->render('pages/user/adress.html.twig',[
            'formAdress' => $formAdress->createView(),
            'adress' => $adress
        ]);
    }

    /**
     * @Route("/profilEdit", name="profilEdit")
     */
    public function profilEdit(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $formEditProfil = $this->createForm(ProfilType::class,$user);

        $formEditProfil->handleRequest($request);

        if ($formEditProfil->isSubmitted() && $formEditProfil->isValid())
        {


            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre profil a été mis à jour.'
            );

            return $this->redirectToRoute('profilEdit');

        }

        return $this->render('pages/user/profilEdit.html.twig',[
            'formEditProfil' => $formEditProfil->createView(),
            'editProfil' => $formEditProfil,
            'avatar' => $user->getAvatar()
        ]);

    }

    /**
     * @Route("/avatarEdit", name="avatarEdit")
     */
    public function avatarEdit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $formAvatar = $this->createForm(AvatarType::class);

        $formAvatar->handleRequest($request);

        if ($formAvatar->isSubmitted() && $formAvatar->isValid()){

            $sub = $request->request->get('avatar');

            $user->setAvatar($sub['avatar']);

            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre avatar a été mis a jour.'
            );

            return $this->redirectToRoute('profilEdit');

        }

        return $this->render('pages/user/avatarEdit.html.twig',[
            'formAvatar' => $formAvatar->createView(),
            'editProfil' => $formAvatar
        ]);
    }

    /**
     * @Route("/userConfig", name="userConfig")
     */
    public function userConfig(request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        $operationListAdd = new OperationList;
        $formOperationListAdd = $this->createForm(OperationListAddType::class,$operationListAdd);

        $formOperationListAdd->handleRequest($request);

        if ($formOperationListAdd->isSubmitted() && $formOperationListAdd->isValid()) {

            $operationListAdd->setUser($user);
            $operationListAdd->setEnable('1');

            $em->persist($operationListAdd);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre opération a été créé.'
            );

            return $this->redirectToRoute('userConfig');
     
        }

        $optionListAdd = new OptionList;
        $formOptionListAdd = $this->createForm(OptionListAddType::class,$optionListAdd);

        $formOptionListAdd->handleRequest($request);

        if ($formOptionListAdd->isSubmitted() && $formOptionListAdd->isValid()) {

            $optionListAdd->setUser($user);
            $optionListAdd->setEnable('1');

            $em->persist($optionListAdd);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre option a été créé.'
            );

            return $this->redirectToRoute('userConfig');
     
        }

        $repo = $em->getRepository(OperationList::class);
        $operationsToShow = $repo->findBy([
            'user' => $user,
            'enable' => '1'
        ],
        );

        $repo = $em->getRepository(OptionList::class);
        $optionsToShow = $repo->findBy([
            'user' => $user,
            'enable' => '1'
        ],
        );

        return $this->render('pages/user/config.html.twig',[
            'formOperationListAdd' => $formOperationListAdd->createView(),
            'operations' => $operationsToShow,
            'formOptionListAdd' => $formOptionListAdd->createView(),
            'options' => $optionsToShow
        ]);

    }


    /**
     * @Route("/userConfig/deleteOperation/{id}", name="userConfigDeleteOperation")
     */
    public function deleteOperation(request $request, $id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $repo = $em->getRepository(OperationList::class);
        $operationsToDelete = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id
        ],
        );

        
        if (!empty($operationsToDelete)) {

            $operationsToDelete->setEnable(0);
            $em->persist($operationsToDelete);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre opération a bien été supprimé.'
            );

        }
        else
        {

            $this->addFlash(
                'alert',
                'Il n\'y a rien à supprimer. Cet élément a déjà été supprimé ou il ne vous appartient pas.'
            );
    
        }

        return $this->redirectToRoute('userConfig');

    }

    /**
     * @Route("/userConfig/deleteOption/{id}", name="userConfigDeleteOption")
     */
    public function deleteOption(request $request, $id, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $repo = $em->getRepository(OptionList::class);
        $optionsToDelete = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id
        ],
        );

        
        if (!empty($optionsToDelete)) {

            $optionsToDelete->setEnable(0);
            $em->persist($optionsToDelete);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre option a bien été supprimé.'
            );

        }
        else
        {

            $this->addFlash(
                'alert',
                'Il n\'y a rien à supprimer. Cet élément a déjà été supprimé ou il ne vous appartient pas.'
            );
    
        }

        return $this->redirectToRoute('userConfig');

    }

    /**
     * @Route("/userCollaborater", name="userCollaborater")
     */
    public function collaborater(EntityManagerInterface $em, request $request, UserRepository $repo): Response
    {
        $searchCollaborater = new User;
        $usersToFind = new User;

        $formSearchCollaborater = $this->createForm(SearchCollaboraterType::class,$searchCollaborater);

        $formSearchCollaborater->handleRequest($request);

        if ($formSearchCollaborater->isSubmitted() && $formSearchCollaborater->isValid()){

            $param['pseudo'] = $formSearchCollaborater->getData()->getPseudo();
            $param['firstName'] = $formSearchCollaborater->getData()->getFirstName();

            $usersToFind = $repo->findUser($param);

        }

        return $this->render('pages/user/collaborater.html.twig',[
            'searchResult' => $formSearchCollaborater->createView(),
            'usersResults' => $usersToFind
        ]);

    }

}