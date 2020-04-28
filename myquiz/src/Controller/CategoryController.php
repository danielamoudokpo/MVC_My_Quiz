<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Categorie::class);

        $categorie = $repository->findAll();

        return $this->render('category/index.html.twig', [
            'Categorie'=> $categorie,
        ]);
    }

}
