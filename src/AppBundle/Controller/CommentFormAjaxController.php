<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\CommentType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentFormAjaxController extends Controller
{
    
    /**
     * 
     * @Route("/question/render-question-comment-form", options={"expose"=true}, name="render_question_comment_form")
     */
    public function renderQuestionCommentFormAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $question = $request->request->get('question');
            $form = $this->createForm(CommentType::class);
            
            return $this->render("AppBundle:Question:question_comment_form.html.twig", 
                    array(
                        'comment_form' => $form->createView(),
                        'question' => $question
                    ));
        } else {
            return new NotFoundHttpException();
        }
    }
    
    /**
     * 
     * @Route("/question/render-answer-comment-form", options={"expose"=true}, name="render_answer_comment_form")
     */
    public function renderAnswerCommentFormAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $question = $request->request->get('question');
            $answer = $request->request->get('answer');
            $form = $this->createForm(CommentType::class);
            
            return $this->render("AppBundle:Question:answer_comment_form.html.twig", 
                    array(
                        'comment_form' => $form->createView(),
                        'question' => $question,
                        'answer' => $answer
                    ));
        } else {
            return new NotFoundHttpException();
        }
    }
}
