<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Categorie;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

        /**
     * @Route("/show/{id}", name= "user_show",methods={"GET","HEAD"})
     */

    public function show($id){

        $categorie = $this->getDoctrine()
        ->getRepository(Categorie::class)
                ->find($id);
        // dd($categorie);

        $questions = $categorie->getQuestions();
        $name = $categorie->getName();
        
        // dd($questions);
        return $this->render("user/show.html.twig",[
            'Questions' => $questions,
            'Name' => $name,
        ]);
    
        }
}
