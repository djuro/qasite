<?php

namespace AppBundle\Service\Application;

use AppBundle\View\QuestionView;
use AppBundle\Service\Application\QuestionService;
use AppBundle\View\CommentView;
use AppBundle\View\AuthorView;
use AppBundle\Entity\User;
use AppBundle\Entity\Question;

class QuestionViewFactory
{
    use AuthorViewFactory;
    
    /**
     *
     * @var QuestionService
     */
    private $questionService;
    
    /**
     *
     * @var AnswerViewFactory
     */
    private $answerViewFactory;
    
    /**
     * 
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService, AnswerViewFactory $answerViewFactory)
    {
        $this->questionService = $questionService;
        $this->answerViewFactory = $answerViewFactory;
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
            $questionView->setScore($question->getScore());
            $views[] = $questionView;
        }
        return $views;
    }
    
    /**
     * 
     * @param Question $question
     * @return QuestionView
     */
    public function createFromQuestion(Question $question)
    {
        $questionView = new QuestionView($question->getId(), $question->getTitle(), $question->getBody());
        $answers = $question->getAnswers()->toArray();
        $comments = $question->getComments()->toArray();
        $questionView->setAuthor($this->createAuthorView($question->getAuthor()))
                ->setCreatedAt($question->getCreatedAt());
        
        $this->createCommentViews($comments, $questionView);
        $this->createAnswerViews($answers, $questionView);
        
        return $questionView;
    }
    
    /**
     * 
     * @param Comment[] $comments
     * @param QuestionView $questionView
     */
    private function createCommentViews(array $comments, QuestionView $questionView)
    {
        foreach($comments as $comment) {
            $authorView = $this->createAuthorView($comment->getAuthor());
            $commentView = new CommentView($comment->getBody(), $comment->getCreatedAt(), $authorView);
            $questionView->addComment($commentView);
        }
    }
    
    /**
     * 
     * @param Answer[] $answers
     * @param QuestionView $questionView
     */
    private function createAnswerViews(array $answers, QuestionView $questionView) {
        foreach($answers as $answer) {
            $answerView = $this->answerViewFactory->createFrom($answer);
            $questionView->addAnswer($answerView);
        }
    }
    
    
}
