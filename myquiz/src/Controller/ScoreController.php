<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Score;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScoreController extends AbstractController
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
     * @Route("/score/{categorieId}/{grade}", name="score")
     */
    
    public function index(Request $request,Categorie $categorieId,$grade)
    {

        $user_id = $this->security->getUser(); 

        $score = new Score;

        $score ->setUser($user_id);
        $score ->setCategorie($categorieId);
        $score ->setGrade($grade);
        $score ->setCreatedAt(new \DateTime('now'));

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($score);

        $entityManager->flush();

        return $this->render("score/index.html.twig",[
            'Score'=> $score,
        ]);


    }
}
