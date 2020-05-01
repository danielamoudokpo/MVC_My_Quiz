<?php

namespace App\Controller;

// use dump;
use App\Entity\Reponse;
use App\Entity\Question;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
         $this->render('question/index.html.twig', [
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

        return $this->redirectToRoute("show_question", ['idCategorie' => $categorieId, 'idQuestion' => $firstId ]);

        
    
        }

    /**
     *  @Route("show/{idCategorie}/{idQuestion}", name="show_question")
    */

    public function question(Request $request, Categorie $idCategorie,Question $idQuestion){


        $qId = $idQuestion->getId();

        $da =$idCategorie->getQuestions();

        $quesInCat = [];

        foreach ($da as $key => $value) {
            
            $id = $value->getId();

            array_push($quesInCat,$id);

        }
        // print_r($quesInCat);

        if(array_search($qId,$quesInCat) === false){

            $this->addFlash(
                'notice',
                'Ther is no more questions!'
            );

            $qs = $this->getDoctrine()->getRepository(Question::class)->find($qId);
            
        }else{

            $qs = $this->getDoctrine()->getRepository(Question::class)->find($qId);

        }

        // echo ($request->request->get('reponse'));

        $responseChoosen = $request->request->get('reponse');

        // echo($responseChoosen);   


        // dd($qId);
        if (isset($responseChoosen)) {
        
        $repo = $this->getDoctrine()->getRepository(Reponse::class)->findOneById($responseChoosen);
        // dd($repo);
        $check = $repo->getReponseExpected();

        if ($check == 1) {
            echo "oui";

            $this->addFlash(
                'success',
                'Correct Answer!'
            );

        }

        }
        // print_r($repo);

        // $rpExp = $repo->getReponseExpected();

        // print_r($rpExp);

        // shuffle($qs);

        return $this->render("user/show.html.twig",[
            'Categorie' => $idCategorie,
            'Questions'=> $qs,
        ]);
        
    }

}
