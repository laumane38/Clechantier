<?php

namespace App\Controller;

use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Require ROLE_USER for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/articleAdd", name="articleAdd")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $formArticleAdd = $this->createForm(ArticleType::class);
        if ($request->isMethod('POST')) {

 
            $formArticleAdd->submit($request->request->get($formArticleAdd->getName()));

            if ($formArticleAdd->isSubmitted() && $formArticleAdd->isValid()) {
                
            }
        }


        return $this->render('pages/articleAdd.html.twig', [
        'formArticleAdd' => $formArticleAdd->createView()
    ]);
    }
    
}
