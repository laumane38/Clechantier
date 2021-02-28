<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlePublicController extends AbstractController
{
    /**
     * @Route("/planning/{id}/{year}/{month}", name="articlePlanning")
     */
    public function planning($id, $month = null, $year = null, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if($year == null)
        {
            $year = date("Y");
        }

        if($month == null)
        {
            $month = date("m");
        }

        $firstDayOfMonth = date("w", mktime(0, 0, 0, $month, 1, $year));
        if($firstDayOfMonth==0) $firstDayOfMonth=7;
        $firstDayOfMonth = 2-$firstDayOfMonth;

        $nbDaysInMonth = date('t',mktime(0, 0, 0, $month, 1, $year));

        $nbWeek = ceil(($nbDaysInMonth-$firstDayOfMonth+1)/7);

        $repo = $em->getRepository(Article::class);
        $article = $repo->findOneBy([
            'user' => $user,
            'enable' => '1',
            'id' => $id
        ],
        );

        $dataDate = [
            'year' => $year, 
            'month' => $month, 
            'prevMonth' => $month-1, 
            'nextMonth' => $month+1,
            'firstDayOfMonth' => $firstDayOfMonth,
            'nbDaysInMonth' => $nbDaysInMonth,
            'nbWeek' => $nbWeek
        ];

        return $this->render('pages/article/planning.html.twig', [
            'article' => $article,
            'dataDate' => $dataDate
            ]
        );
    }
}
