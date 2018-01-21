<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Entity\AnswerComment;
use AppBundle\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;

use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    const BODY = "Some arbitrary text as answer body ...";
    
    const TITLE = "Some title text";
    
    /**
     *
     * @var Answer
     */
    private $answer;
    
    
    public function setUp()
    {
        $question = $this->createQuestion();
        $user = $this->createUserMock();
        $this->answer = new Answer($question, $user);
    }
    
    /**
     * 
     * @param Question $question
     * @param User $user
     * @dataProvider providerForTestConstructor
     */
    public function testConstructor(Question $question, User $user)
    {
        $answer = new Answer($question, $user);
        $this->assertTrue($answer->getId() instanceof Uuid);
        $this->assertTrue(is_numeric($answer->getCreatedAt())&&$answer->getCreatedAt()>0);
        $this->assertTrue($answer->getComments() instanceof ArrayCollection);
    }
    
    public function testSetGetBody()
    {
        $this->answer->setBody(self::BODY);
        $this->assertEquals($this->answer->getBody(), self::BODY);
    }
    
    public function testSetGetQuestion()
    {
        $question = new Question();
        $question->addAnswer($this->answer);
        $this->assertTrue($this->answer->getQuestion()===$question);
    }
    
    public function testAddRemoveComment()
    {
        $comment = new AnswerComment();
        $this->answer->addComment($comment);
        $this->assertTrue($this->answer->getComments()->first() === $comment);
        $this->answer->removeComment($comment);
        $this->assertTrue(count($this->answer->getComments()->toArray())==0);
    }
    
    public function providerForTestConstructor()
    {
        
        $question = $this->createQuestion();
        $userMock = $this->createUserMock();
        
        
        return array(
            array($question, $userMock)
        );
    }
    
    /**
     * 
     * @return Question
     */
    private function createQuestion() {
        $question = new Question();
        $question->setTitle(self::TITLE)
                ->setBody(self::BODY);
        return $question;
    }
    
    /**
     * 
     * @return User
     */
    private function createUserMock() {
        $userMock = $this->getMockBuilder('AppBundle\Entity\User')
                                ->disableOriginalConstructor()
                                ->setMethods(null)
                                ->getMock();
        return $userMock;
    }
}
