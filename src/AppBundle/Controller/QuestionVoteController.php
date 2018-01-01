<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Entity\User;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class QuestionVoteController extends Controller
{
    
    const Q_UPSCORE_LOCKED = "User already up-voted the question.";
    
    const Q_DOWNSCORE_LOCKED = "User already down-voted the question.";
    
    /**
     * @Route("/upvote/question/{question}", options={"expose"=true}, name="upvote_question")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     */
    public function upVoteAction(Request $request, Question $question)
    {
        if($request->isXmlHttpRequest()) {
            $voteRepository = $this->get('qasite.vote_repository');
            $questionService = $this->get('qasite.question_service');
            $user = $this->getUser();
            $upvoted = $voteRepository->findIfUpvotedBy($question, $user);
            $response = new Response();
            if(FALSE === $upvoted) {
                $questionService->recordUpvote($question, $user);
                $response->setStatusCode(200)
                        ->setContent($question->getScore());
                return $response;
            } else {
                $response->setStatusCode(423)
                        ->setContent(self::Q_UPSCORE_LOCKED);
                return $response;
            }
        } else {
            throw new NotFoundHttpException();
        }
    }
    
    /**
     * @Route("/downvote/question/{question}", options={"expose"=true}, name="downvote_question")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     */
    public function downVoteAction(Request $request, Question $question)
    {
        if($request->isXmlHttpRequest()) {
            $voteRepository = $this->get('qasite.vote_repository');
            $questionService = $this->get('qasite.question_service');
            $user = $this->getUser();
            
            $downVoted = $voteRepository->findIfDownvotedBy($question, $user);
            $response = new Response();
            if(FALSE === $downVoted) {
                $questionService->recordDownvote($question, $user);
                $response->setStatusCode(200)
                        ->setContent($question->getScore());
                return $response;
            } else {
                $response->setStatusCode(423)
                        ->setContent(self::Q_DOWNSCORE_LOCKED);
                return $response;
            }
        } else {
            throw new NotFoundHttpException();
        }
    }
}
