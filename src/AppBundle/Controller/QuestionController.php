<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\QuestionType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    /**
     * @Route("/question/new", name="new_question")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(QuestionType::class);
        
        return $this->render("AppBundle:Question:new.html.twig", 
                array('form'=>$form->createView()));
    }
}
