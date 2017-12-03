<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\QuestionType;

use AppBundle\Entity\Question;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    /**
     * @Route("/question/new", name="question_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(QuestionType::class);
        
        $form->handleRequest($request);
        if($form->isSubmitted()) {
        if($form->isValid()) {
            $questionService = $this->get('qasite.question_service');
            $questionRepository = $this->get('qasite.question_repository');
            $formQuestion = $form->getData();
            $question = $questionService->transformFormQuestion($formQuestion);
            $questionRepository->persist($question);
            $questionRepository->emFlush();
            return $this->redirect($this->generateUrl('question_list'));
    }}
        return $this->render("AppBundle:Question:new.html.twig", 
                array('form'=>$form->createView()));
    }
    
    /**
     * @Route("/question/list", name="question_list")
     */
    public function listAction()
    {
        $questionRepository = $this->get('qasite.question_repository');
        $questions = $questionRepository->findAll();
        $viewFactory = $this->get('qasite.question_view_factory');
        $questionViews = $viewFactory->createFrom($questions);
        return $this->render("AppBundle:Question:list.html.twig", 
                array(
                    'questions' => $questionViews
                ));
    }
    
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        return $this->redirect($this->generateUrl('question_list'));
    }
}
