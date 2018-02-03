<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\QuestionType;
use AppBundle\Form\Type\CommentType;
use AppBundle\Entity\User;
use AppBundle\Entity\Question;
use AppBundle\Form\Type\AnswerType;
use AppBundle\Entity\Answer;
use AppBundle\Form\Model\Question as FormQuestion;
use AppBundle\Entity\QuestionComment;
use AppBundle\Entity\AnswerComment;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use \Exception;

class QuestionController extends Controller
{
    /**
     * @Route("/question/new", name="question_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(QuestionType::class);
        $user = $this->getUser();
        //d($user); exit;
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $question = new Question();
            $question->setAuthor($user);
            $questionService = $this->get('qasite.question_service');
            $questionRepository = $this->get('qasite.question_repository');
            $formQuestion = $form->getData();
            $questionService->transformFormQuestion($question, $formQuestion);
            $questionRepository->persist($question);
            $questionRepository->emFlush();
            return $this->redirect($this->generateUrl('question_list'));
    }
        return $this->render("AppBundle:Question:new.html.twig", 
                array('form'=>$form->createView()));
    }
    
    /**
     * @Route("/questions", name="questions")
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
        $questionViewFactory = $this->get('qasite.question_view_factory');
        $questionView = $questionViewFactory->createFromQuestion($question);
        
        $answerForm = $this->createForm(AnswerType::class);
        $commentForm = $this->createForm(CommentType::class);
        $answerCommentForm = $this->createForm(CommentType::class);
        $answerForm->handleRequest($request);
        
        if($answerForm->isSubmitted() && $answerForm->isValid()) {
            $answerText = $answerForm->getData()['answer'];
            $this->processAnswerResponse($question, $answerText);
            return $this->redirect($this->generateUrl('question_view', 
                    array('question'=>$question->getId())));
        }
        return $this->render("AppBundle:Question:view.html.twig", 
                array(
                    'question_view' => $questionView, 
                    'answer_form' => $answerForm->createView(),
                    'comment_form' => $commentForm->createView(),
                    'answer_comment_form' => $answerCommentForm->createView(),
                    'authenticated' => $this->resolvePermission(),
                ));
    }
    
    /**
     * 
     * @param Question $question
     * @param string $answerText
     */
    private function processAnswerResponse(Question $question, $answerText) {
        $answerRepository = $this->get('qasite.answer_repository');
        $answer = new Answer($question, $this->getUser());
        $answer->setBody($answerText);
        $answerRepository->persist($answer);
        $answerRepository->flush();
    }
    
    /**
     * @Route("/question/{question}/comment/new", name="question_comment_new")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     */
    public function storeQuestionCommentAction(Request $request, Question $question)
    {
        $commentForm = $this->createForm(CommentType::class);
        $commentForm->handleRequest($request);
        if($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = new QuestionComment;
            $comment->setQuestion($question)
                    ->setBody($commentForm->getData()['comment'])
                    ->setAuthor($this->getUser());
            $commentRepository = $this->get('qasite.comment_repository');
            $commentRepository->persist($comment);
            $commentRepository->flush();
            return $this->redirect($this->generateUrl('question_view', 
                    array('question'=>$question->getId())));
        }
        
    }
    
    /**
     * @Route("/question/{question}/answer/{answer}/comment/new", name="answer_comment_new")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     * @ParamConverter("answer", options={"mapping": {"answer": "id"}})
     */
    public function storeAnswerCommentAction(Request $request, Question $question, Answer $answer)
    {
        $commentForm = $this->createForm(CommentType::class);
        $commentForm->handleRequest($request);
        if($commentForm->isValid()) {
            $comment = new AnswerComment;
            $comment->setAnswer($answer)
                    ->setBody($commentForm->getData()['comment'])
                    ->setAuthor($this->getUser());
            $commentRepository = $this->get('qasite.comment_repository');
            $commentRepository->persist($comment);
            $commentRepository->flush();
            return $this->redirect($this->generateUrl('question_engage', 
                    array('question'=>$question->getId())));
        }
    }
    
    /**
     * @Route("/question/{question}/edit", name="question_edit")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     */
    public function editAction(Request $request, Question $question)
    {
        //Kint::trace(); // Debug backtrace
         //d($request); exit;
        $questionService = $this->get('qasite.question_service');
        $formQuestion = new FormQuestion;
        $questionService->transformDomainQuestion($question, $formQuestion);
        $form = $this->createForm(QuestionType::class, $formQuestion);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $questionRepository = $this->get('qasite.question_repository');
            $questionService->transformFormQuestion($question, $formQuestion);
            $questionRepository->emFlush();
            return $this->redirect($this->generateUrl('question_view', 
                    array('question'=>$question->getId()
                    )));
        }
    
        return $this->render("AppBundle:Question:edit.html.twig",
                array(
                    'form'=>$form->createView()
                    )
                );
    }
    
    private function resolvePermission() {
        if($this->getUser() instanceof User)
            return TRUE;
        else 
            return FALSE;
    }
    
}
