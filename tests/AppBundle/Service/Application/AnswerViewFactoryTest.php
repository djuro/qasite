<?php

namespace Tests\AppBundle\Service\Application;

use AppBundle\Entity\Question;
use AppBundle\Entity\User;
use AppBundle\Entity\AnswerComment;
use AppBundle\Entity\Answer;
use AppBundle\View\AnswerView;

use PHPUnit\Framework\TestCase;

class AnswerViewFactoryTest extends TestCase
{
    const TTLE = "Some fancy title ...";
    
    const BDY = "Some shiny new body ...";
    
    
    /**
     * 
     * @dataProvider providerForTestCreate 
     */
    public function testCreateFrom(Answer $answer)
    {
        $answerViewFactory = $this->getMockBuilder('AppBundle\Service\Application\AnswerViewFactory')
                ->setMethods(NULL)
                ->getMock();
        
        $answerView = $answerViewFactory->createFrom($answer);
        $this->assertTrue($answerView instanceof AnswerView);
    }

    /**
     * 
     * @return Question[]
     */
    public function providerForTestCreate()
    {
        $question = new Question();
        $question->setTitle(self::TTLE)
                ->setBody(self::BDY)
                ->setAuthor(new User());
        $comment = new AnswerComment();
        $comment->setAuthor(new User());
        
        $answer = new Answer($question, new User());
        $answer->setBody(self::BDY);
        $answer->addComment($comment);
        
        return array(
            array($answer)
        );
    }
}
