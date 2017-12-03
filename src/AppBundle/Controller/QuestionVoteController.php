<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Entity\User;
use AppBundle\Entity\UpVote;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class QuestionVoteController extends Controller
{
    /**
     * @Route("/upvote/question/{question}", options={"expose"=true}, name="upvote_question")
     * @ParamConverter("question", options={"mapping": {"question": "id"}})
     */
    public function upVoteAction(Request $request, Question $question)
    {
        if($request->isXmlHttpRequest()) {
            $upVote = new UpVote($this->getUser(), $question);
            $voteRepository = $this->get('qasite.vote_repository');
            $questionService = $this->get('qasite.question_service');
            $voteRepository->storeUpVote($upVote);
            $voteRepository->emFlush();
            $totalVoteScore = $questionService->calculateVotesFor($question);
            $response = new Response();
            $response->setStatusCode(200)
                    ->setContent($totalVoteScore);
            
            return $response;
        } else {
            throw new NotFoundHttpException();
        }
    }
}
