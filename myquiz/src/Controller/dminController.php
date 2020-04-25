<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class dminController extends AbstractController
{


    // public function adminDashboard()
    // {
    //     $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
    //     // or add an optional message - seen by developers
    //     $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    // }
    
    /**
     * @Route("/dmin", name="dmin")
     */
    public function index()
    {
        return $this->render('dmin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }


}
