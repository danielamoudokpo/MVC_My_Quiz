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
     * @Route("/show/{categorie_id}", name= "user_show",methods={"GET","HEAD"})
     */

    public function show($categorie_id){

        $categorie = $this->getDoctrine()
        ->getRepository(Categorie::class)
                ->find($categorie_id);
        // dd($categorie);

        $re =1;

        

        $reponses = $this->getDoctrine()
        ->getRepository(Question::class)
                    ->find($re);

      

        $reponse = $reponses->getReponses();
        // dd($reponse);

        $questions = $categorie->getQuestions();

        // $question_id = $categorie->getQuestions();

        // dd($question_id);

        $name = $categorie->getName();
        
        // dd($reponse[1]);
        // dd($questions[1]);
        return $this->render("user/show.html.twig",[
            'Questions' => $questions,
            'Name' => $name,
            'Reponse'=> $reponse,    
        ]);
    
        }

    /**
     *  @Route("show/{category_id}/{question_id}", name="show_question")
    */

    public function question(){



    }

}
