<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\QuestionType;
use AppBundle\Entity\User;
use AppBundle\Entity\Question;
use AppBundle\Form\Type\AnswerType;
use AppBundle\Entity\Answer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
     * @Route("/questions", name="questions")
     */
    public function listAction()
    {   
        $questionRepository = $this->get('qasite.question_repository');
        $questions = $questionRepository->findAll();
        $viewFactory = $this->get('qasite.question_view_factory');
        $questionViews = $viewFactory->createFrom($questions);
        return $this->render("AppBundle:Question:list.html.twig", 
                array(
                    'questions' => $questionViews,
                    'links_active' => $this->resolvePermission()
                ));
    }
    
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
        return $this->redirect($this->generateUrl('questions'));
    }
    
    /**
     * @Route("/question/{question}/view", name="question_view")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     */
    public function questionViewAction(Request $request, Question $question)
    {
        $form = $this->createForm(AnswerType::class);
        $form->handleRequest($request);
        if($form->isValid()) {
            $answerRepository = $this->get('qasite.answer_repository');
            $answerText = $form->getData()['answer'];
            $answer = new Answer($question, $this->getUser());
            $answer->setBody($answerText);
            $answerRepository->persist($answer);
            $answerRepository->flush();
            return $this->redirect($this->generateUrl('questions'));
        }
        return $this->render("AppBundle:Question:view.html.twig", 
                array(
                    'question' => $question,
                    'form' => $form->createView(),
                    'display_form' => $this->resolvePermission(),
                    'answers' => $question->getAnswers()->toArray()
                ));
    }
    
    /**
     * @Route("/question/{question}/edit", name="question_edit")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     */
    public function editAction(Request $request, Question $question)
    {
        //d(1);
        //d($question); 
        //exit;
    }
    
    private function resolvePermission() {
        if($this->getUser() instanceof User)
            return TRUE;
        else 
            return FALSE;
    }
}
