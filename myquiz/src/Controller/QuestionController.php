<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Categorie;
use App\Entity\Reponse;
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
     * @Route("/show/{categorieId}", name= "user_show",methods={"GET","HEAD"})
     */

    public function show($categorieId){

        $categorie = $this->getDoctrine()
        ->getRepository(Categorie::class)
                ->find($categorieId);

        $questions = $categorie->getQuestions();

        $firstId = $questions[0]->getId();

        return $this->redirectToRoute("show_question", ['categorie' => $categorieId, 'question' => $firstId ]);

        
    
        }

    /**
     *  @Route("show/{categorie}/{question}", name="show_question")
    */

    public function question( Categorie $categorie,Question $question){


        // $questions = $categorie->getQuestions();

        $qId = $question->getId();

        // $catId = $categorie->getId();

        // dd($qId);

        $qs = $this->getDoctrine()->getRepository(Question::class)->find($qId);

        // echo $catId,$qId;

        return $this->render("user/show.html.twig",[
            // 'Questions' => $questions,
            'Categorie' => $categorie,
            'Qus'=> $qs,
            // 'Reponse'=> $reponse, 
        ]);

    }

}
