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
     * @Route("/question/render-comment-form", options={"expose"=true}, name="question_render_comment_form")
     */
    public function renderCommentFormAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $question = $request->request->get('question');
            $answer = $request->request->get('answer');
            $form = $this->createForm(CommentType::class);
            
            return $this->render("AppBundle:Question:comment_form.html.twig", 
                    array(
                        'comment_form' => $form->createView(),
                        'question' => $question,
                        'answer' => $answer
                    ));
        } else {
            return new NotFoundHttpException;
        }
    }
}
