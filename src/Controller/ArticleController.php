<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
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
class ArticleController extends AbstractController
{
    /**
     * @Route("/add", name="articleAdd")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        
        $user = $this->getUser();
        $article = new Article();

        $formArticleAdd = $this->createForm(ArticleType::class,$article);

        $formArticleAdd->handleRequest($request);

        if ($formArticleAdd->isSubmitted() && $formArticleAdd->isValid()) {

            $article->setOwner($user);
            $article->setEnable('1');

            $em->persist($article);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre article a été créé.'
            );

            return $this->redirectToRoute('articleShow');
     
        }

        return $this->render('pages/article/add.html.twig', [
        'formArticleAdd' => $formArticleAdd->createView()
        ]);
    
    }

    /**
     * @Route("/show", name="articleShow")
     */
    public function show(EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $repo = $em->getRepository(Article::class);
        $articleToShow = $repo->findBy([
            'owner' => $user,
            'enable' => '1'
        ]);

        return $this->render('pages/article/show.html.twig',[
            'articles' => $articleToShow
        ]);

    }

    /**
     * @Route("/delete/article/{id}", name="delete")
     */
    public function delete($id,EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $repo = $em->getRepository(Article::class);
        $articleToDisable = $repo->findOneBy([
            'owner' => $user,
            'enable' => '1',
            'id' => $id
        ],);

        if (!empty($articleToDisable)) {

            $articleToDisable->setEnable(0);
            $em->persist($articleToDisable);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre article a bien été supprimé.'
            );

        }

        return $this->redirectToRoute('articleShow');

    }

}
