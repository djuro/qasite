<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Answer;
use AppBundle\Entity\AnswerComment;
use AppBundle\Entity\Question;
use AppBundle\Entity\User;

use PHPUnit\Framework\TestCase;

class AnswerCommentTest extends TestCase
{
    const BODY = "Some text ...";
    
    const TITLE = "Some title ...";
    
    /**
     * 
     * @param Question $question
     * @param User $user
     * @dataProvider providerForTestSetGetAnswer
     */
    public function testSetGetAnswer(Question $question)
    {
        $userMock = $this->getMockBuilder('AppBundle\Entity\User')
                                ->disableOriginalConstructor()
                                ->setMethods(null)
                                ->getMock();
        $answer = new Answer($question, $userMock);
        $answerComment = new AnswerComment();
        $answer->addComment($answerComment);
        $this->assertTrue($answerComment->getAnswer() === $answer);
    }
    
    public function providerForTestSetGetAnswer()
    {
        $question = new Question();
        $question->setBody(self::BODY)
                ->setTitle(self::TITLE);
        
        return array(
            array($question)
        );
    }
}
