<?php // src/App/Controller/QuestionController.php

namespace App\Controller;

use App\Form\QuestionType;
use Forum\Question\Question;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class QuestionController extends Controller
{
    /**
     * @Route("/", name="question_list")
     */
    public function listAction()
    {
        $questions = $this->get('repository.question')->findAll();

        return $this->render('question/list.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/new", name="question_create")
     * @Security("is_authenticated()")  Se añade la anotación de seguridad
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(QuestionType::class, null, [
            'author' => $this->getUser()->getUsername(), // Se pasa el usuario logueado al form.
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $this->get('repository.question')->save($form->getData());

            return $this->redirectToRoute('question_list');
        }

        return $this->render('question/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
