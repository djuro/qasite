<?php

namespace AppBundle\Service\Application;

use AppBundle\View\QuestionView;
use AppBundle\Service\Application\QuestionService;

class QuestionViewFactory
{
    /**
     *
     * @var QuestionService
     */
    private $questionService;
    
    /**
     * 
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }
    
    /**
     * 
     * @param Question[] $questions
     * @return QuestionView[]
     */
    public function createFrom(array $questions)
    {
        $views = array();
        foreach($questions as $question)
        {
            $questionView = new QuestionView($question->getId(), $question->getTitle(), $question->getBody());
            //$score = $this->questionService->calculateVotesFor($question);
            $questionView->setScore($question->getScore());
            $views[] = $questionView;
        }
        return $views;
    }
}
