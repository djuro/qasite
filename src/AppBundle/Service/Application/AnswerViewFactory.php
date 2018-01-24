<?php

namespace AppBundle\Service\Application;

use AppBundle\Entity\Answer;
use AppBundle\View\AnswerView;

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
        $answerView = new AnswerView($answer->getBody(), $answer->getCreatedAt(), $authorView);
        return $answerView;
    }
}
