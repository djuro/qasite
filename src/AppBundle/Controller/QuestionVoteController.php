<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionVoteController extends Controller
{
    /**
     * @Route("/vote/up", name="vote_up")
     */
    public function voteUpAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            
        } else {
            throw new NotFoundHttpException();
        }
    }
}
