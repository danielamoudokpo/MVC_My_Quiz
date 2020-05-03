<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\QuizFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizController extends AbstractController
{
    /**
     * @Route("/quiz", name="quiz")
     */
    public function index(Request $request): Response
    {
        $cat = new Categorie();

        $form = $this->createForm(QuizFormType::class,$cat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $catName = $form->get('name')->getData();

            // $catQus = $form->get('Questions')->getData();

            // $catQus = explode(" ",$catQus);

            // dd($catQus);
            // $cat->addQuestion($catQus);

            $cat->setName($catName);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('home');


        }



        return $this->render('quiz/index.html.twig', [
            'quizForm' => $form->createView(),
        ]);
    }
}
