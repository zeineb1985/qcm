<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use  Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\QuestionRepository;


use App\Entity\Question;
use App\Repository\ReponseRepository;

class QuestionController extends AbstractController
{


    /**
     * @Route("/", name="question")
     */
    public function questionList(QuestionRepository $questionRepository): Response
    {


        $questions = $questionRepository->findAll();
        return $this->render(
            'quiz/list.html.twig',
            ['questions' => $questions]

        );
    }



    /**
     * @Route("/question", name="add_question")
     */
    public function index(Request $request): Response
    {


        $question = new Question();
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('title', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $question->setTitle($request->request->get('form')['title']);
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('question');
        }


        return $this->render('question/index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/test", name="test_qcm")
     */

    public function test(QuestionRepository $questionRepository, ReponseRepository $reponseRepository): response
    {

        $questions = $questionRepository->findAll();
        return $this->render(
            'question/testQuiz.html.twig',
            ['questions' => $questions]
        );
    }

    /**
     * @Route("/result", name="result_test",methods={"POST"})
     */
    public function resultTest(Request $request)
    {

        if ($request->isMethod('POST')) {
            dd('hello');
        }
    }

    /**
     * @Route("/delete/{id}", name="delete_question")
     */

    public function deleteQuestion(Request $request, $id, Question $question,  QuestionRepository $questionRepository)
    {



        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('title', TextType::class)
            ->add('quiz', TextType::class,
        ['required'=>false])

            ->add('Supprimer', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {

            $em->remove($question);
            $em->flush();
            return $this->redirectToRoute('question');
        }

        return $this->render('question/delete.html.twig', [
            'form' => $form->createView(),
            'question' => $question
        ]);
    }
}
