<?php

namespace App\Controller;

use App\Entity\Score;
use App\Entity\Reponse;
use App\Entity\Question;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{

      /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

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

        $quesInCat=[];

        foreach ($questions as $key => $value) {
            $id = $value->getId();
            array_push($quesInCat,$id);
        }
        $errors = array_filter($quesInCat);

        if (!empty($errors)) {

            $firstId = $questions[0]->getId();

            return $this->redirectToRoute("show_question", ['idCategorie' => $categorieId, 'idQuestion' => $firstId ]);
        }else{
            return $this->redirectToRoute('home');
        } 
    }      // dd($quesInCat);


    /**
     *  @Route("show/{idCategorie}/{idQuestion}", name="show_question")
    */

    public function question(Request $request, Categorie $idCategorie,Question $idQuestion,SessionInterface $session){

        $qId = $idQuestion->getId();

        $da =$idCategorie->getQuestions();

        $quesInCat = [];

        //  QUESTION IN EACH CATEGORY  //

        foreach ($da as $key => $value) {
            $id = $value->getId();
            array_push($quesInCat,$id);
        }

        //  FIRST QUESTION IN ECAH CATEGORY//
        $firstQuestion = $quesInCat[0];

        // WHEN THERE IS NO MORE QUESTIONS (IF QUESTION DOESN'T EXIST IN THE CATEGORY) SEND NOTICE //
        if(array_search($qId,$quesInCat) === false){

            $this->addFlash(
                'notice',
                'Ther is no more questions!'
            );
            $qs = $this->getDoctrine()->getRepository(Question::class)->find($qId);
        }else{
            $qs = $this->getDoctrine()->getRepository(Question::class)->find($qId);
        }

        // AFTER RESPONSE IS CHOOSEN//
        $responseChoosen = $request->request->get('reponse');
        
        //RESET SCORE//
        if($firstQuestion == $qId  ){
            $session->set('ctn', 0);
        }

        // CHECK RESPONSE CHOOSEN BY USER
        $message =[];
        $ctn =0;

        if (isset($responseChoosen)) {
            $repo = $this->getDoctrine()->getRepository(Reponse::class)->findOneById($responseChoosen);
            $check = $repo->getReponseExpected();
            
            if ($check == 1) {
                $ctn++;
                $message =[
                    'Correct' => "Correct Answer"
                ];
                // SESSION && COUNTER START //
                $counter = $session->get('ctn',0);

                    if(!empty($counter)){
                        $counter++;
                    }   
                    else{
                        $counter=1;
                    }

                $session->set('ctn', $counter);
            }
            else{
        
                $message =[
                    'Incorrect' => "Wrong Answer"
                ];
            }
        }

        //  RETRIEVE COUNTER //
        $ctn = $session->get('ctn');

        return $this->render("user/show.html.twig",[
            'Categorie' => $idCategorie,
            'Questions'=> $qs,
            'Message'=> $message,
            'Count' => $ctn,
        ]);
        
    }

}
