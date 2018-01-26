<?php

namespace AppBundle\Service\Application;

use AppBundle\Entity\Answer;
use AppBundle\View\AnswerView;
use AppBundle\View\CommentView;
use AppBundle\Entity\Comment;

class AnswerViewFactory
{
    use AuthorViewFactory;
    
    /**
     * 
     * @param Answer $answer
     * @return AnswerView
     */
    public function createFrom(Answer $answer)
    {
        $authorView = $this->createAuthorView($answer->getCreatedBy());
        $answerView = new AnswerView($answer->getId(), $answer->getBody(), $answer->getCreatedAt());
        $answerView->setAuthor($authorView);
        $this->createCommentViews($answer, $answerView);
        return $answerView;
    }
    
    /**
     * @param Answer $answer
     * @param AnswerView $answerView
     */
    private function createCommentViews(Answer $answer, AnswerView $answerView) {
        $comments = $answer->getComments()->toArray();
        foreach($comments as $comment) {
            $commentView = $this->createCommentView($comment);
            $answerView->addComment($commentView);
        }
    }
    
    /**
     * @param Comment $comment
     * @return CommentView
     */
    private function createCommentView(Comment $comment)
    {
        $authorView = $this->createAuthorView($comment->getAuthor());
        $view = new CommentView($comment->getBody(), $comment->getCreatedAt(), $authorView);
        return $view;
    }
}
