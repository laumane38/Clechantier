<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\OperationList;
use App\Form\ArticleDlImgType;
use App\Form\OperationListAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use  Symfony\Component\HttpFoundation\File\File;


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

            $article->setUser($user);
            $article->setEnable('1');

            $directory = "images/download/";
            $filename = $user->getPseudo()."-".time().".jpg";
            $file = $formArticleAdd['imageMain']->getData();
            $file->move($directory, $filename);

            $article->setImageMain($directory.$filename);

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
        $showByPage = 10;

        $repo = $em->getRepository(Article::class);
        $articleToShow = $repo->findBy([
            'user' => $user,
            'enable' => '1'
            ],[
            'id'=>'DESC'
        ],
        $showByPage
        );
        
        return $this->render('pages/article/show.html.twig',[
            'articles' => $articleToShow
        ]);

    }

    /**
     * @Route("/delete/{id}", name="articleDelete")
     */
    public function delete($id,EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $repo = $em->getRepository(Article::class);
        $articleToDisable = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id
        ],
        );

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

    /**
     * @Route("/detail/{id}", name="articleDetail")
     */
    public function detail(Request $request, $id, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $repo = $em->getRepository(Article::class);
        $articleToShow = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id
        ],
        );

        $image = new Image;
        $formArticleDlImg = $this->createForm(ArticleDlImgType::class,$image);

        $formArticleDlImg->handleRequest($request);

        if ($formArticleDlImg->isSubmitted() && $formArticleDlImg->isValid()) {

            $directory = "images/download/";
            $filename = $user->getPseudo()."-".time().".jpg";

            $file = $formArticleDlImg['path']->getData();
            $file->move($directory, $filename);

            $image->setPath($directory.$filename);
            $image->setArticle($articleToShow);
            $em->persist($image);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre image a bien été téléchargé.'
            );

        }



        $repo = $em->getRepository(Image::class);
        $imagesToShow = $repo->findBy([
            'article' => $articleToShow
            ],
        );


        return $this->render('pages/article/detail.html.twig',[
            'article' => $articleToShow,
            'formArticleDlImg' => $formArticleDlImg->createView(),
            'images' => $imagesToShow
            ]);
    }

    /**
     * @Route("/modify/{id}", name="articleModify")
     */
    public function modify($id, Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        $repo = $em->getRepository(Article::class);
        $articleToModify = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id
        ],
        );

        $formArticleToModify = $this->createForm(ArticleType::class,$articleToModify);

        $formArticleToModify->handleRequest($request);

        if ($formArticleToModify->isSubmitted() && $formArticleToModify->isValid()) {

            $directory = "images/download/";
            $filename = $user->getPseudo()."-".time().".jpg";

            $file = $formArticleToModify['imageMain']->getData();
            $file->move($directory, $filename);

            $articleToModify->setImageMain($directory.$filename);

            $em->persist($articleToModify);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre article a été mofifié.'
            );

            return $this->redirectToRoute('articleShow');
     
        }

        return $this->render('pages/article/modify.html.twig', [
        'formArticleToModify' => $formArticleToModify->createView()
        ]);

    }

}
