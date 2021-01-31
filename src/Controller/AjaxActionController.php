<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AjaxActionController extends AbstractController
{
    /**
     * @Route("/ajax", name="ajax_action")
     */
    public function index(Request $request): Response
    {
        if ($request->isXMLHttpRequest()) {         

           

            return new JsonResponse(array('data' => 'iop'));
        }
    
        return new Response('This is not ajax!', 400);
    }
}
