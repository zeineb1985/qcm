<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\QuestionAddType;
use App\Form\QuestionType;
use App\Form\ReponseType;
use App\Repository\QuestionRepository;

use  Symfony\Component\HttpFoundation\Request;

class QuizController extends AbstractController
{
    /**
     * @Route("/{id}", name="registration_quiz")
     */
    public function index(Request $request, $id, QuestionRepository $questionRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $question = $questionRepository->find($id);

        //$response = new Reponse();
        //$response->setRep('Réponse 1');
        //$response->setStatus(1);
        //$question->getReponses()->add($response);
        $originalRep = new ArrayCollection();


        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            foreach ($originalRep as $response) {

                if ($question->getReponses()->contains($response) === false) {
                    dump("Does not exist");
                    $em->remove($response);
                }
            }



            $em->persist($question);
            $em->flush();
        }
        return $this->render(
            'quiz/index.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    

    /**
     * @Route("/add", name="add-question")
     */
    public function ajoutQuestion(): Response
    {


        return $this->render(
            'quiz/add.html.twig'
        );
    }

/**
     * @Route("/quiz", name="test_quiz")
     */
    public function testQuiz(Request $request): Response
    {
        return $this->render(
            'question/testQuiz.html.twig'
        );

    }    
}
