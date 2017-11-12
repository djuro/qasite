<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Entity\AnswerComment;

use Doctrine\Common\Collections\ArrayCollection;

use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    const BODY = "Some arbitrary text as answer body ...";
    
    /**
     *
     * @var Answer
     */
    private $answer;
    
    public function setUp()
    {
        $this->answer = new Answer();
    }
    
    public function testConstructor()
    {
        $answer = new Answer();
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
}
