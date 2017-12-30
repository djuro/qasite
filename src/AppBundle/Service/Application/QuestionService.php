<?php
namespace AppBundle\Service\Application;

use AppBundle\Service\Repository\VoteRepository;
use AppBundle\Entity\UpVote;
use AppBundle\Entity\DownVote;
use AppBundle\Form\Model\Question as FormQuestion;
use AppBundle\Entity\Question;
use AppBundle\Entity\User;

class QuestionService
{
    /**
     *
     * @var VoteRepository
     */
    private $voteRepository;
    
    /**
     * 
     * @param VoteRepository $voteRepository
     */
    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
    }
    
    /**
     * 
     * @param FormQuestion $formQuestion
     * @return Question
     */
    public function transformFormQuestion(FormQuestion $formQuestion):Question
    {
        $question = new Question();
        $question->setTitle($formQuestion->getTitle())
                ->setBody($formQuestion->getBody());
        return $question;
    }
    
    /**
     * 
     * @param Question $question
     * @param User $user
     */
    public function recordUpvote(Question $question, User $user)
    {
        $upVote = new UpVote($user, $question);
        $question->upVote();
        $this->voteRepository->storeUpVote($upVote);
        $downVoted = $this->voteRepository->findIfDownvotedBy($question, $user);
        if(TRUE===$downVoted)
            $this->voteRepository->removeDownvoteFor($question, $user);
        
        $this->voteRepository->emFlush();
    }
    
    /**
     * 
     * @param Question $question
     * @param User $user
     */
    public function recordDownvote(Question $question, User $user)
    {
        $downVote = new DownVote($user, $question);
        $this->voteRepository->storeDownVote($downVote);
        $question->downVote();
        $upVoted = $this->voteRepository->findIfUpvotedBy($question, $user);
        if(TRUE===$upVoted)
            $this->voteRepository->removeUpvoteFor($question, $user);
        
        $this->voteRepository->emFlush();
    }
}
