<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\QuestionType;

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
        if($form->isValid()) {
            d($form->getData()); exit;
        }
        return $this->render("AppBundle:Question:new.html.twig", 
                array('form'=>$form->createView()));
    }
    
    /**
     * @Route("/question/list", name="question_list")
     */
    public function listAction()
    {
        return $this->render("AppBundle::layout.html.twig");
    }
}
