<?php
namespace AppBundle\Service\Application;

use AppBundle\Service\Repository\VoteRepository;

use AppBundle\Form\Model\Question as FormQuestion;
use AppBundle\Entity\Question;

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
     * @return int
     */
    public function calculateVotesFor(Question $question)
    {
        $upvotes = $this->voteRepository->findUpvotesFor($question);
        $countUpvotes = count($upvotes);
        $downVotes = $this->voteRepository->findDownvotesFor($question);
        $countDownVotes = count($downVotes);
        return (int) $countUpvotes - $countDownVotes;
    }
}
