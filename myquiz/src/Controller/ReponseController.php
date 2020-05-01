<?php

namespace App\Controller;

use App\Entity\Reponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReponseController extends AbstractController
{
    /**
     * @Route("/reponse", name="reponse")
     */
    public function index()
    {
        return $this->render('reponse/index.html.twig', [
            'controller_name' => 'ReponseController',
        ]);
    }

    //   /**
    //  * @Route("/check/{reponse}", name="check_reponse", methods={"POST","GET"})
    //  */
    // public function checkReponse(Request $request)
    // {
    //    dd($request->get('reponse'));

    //     // return "hello";
    //     // return $this->render('reponse/index.html.twig', [
    //     //     'controller_name' => 'ReponseController',
    //     // ]);
    // }
}
