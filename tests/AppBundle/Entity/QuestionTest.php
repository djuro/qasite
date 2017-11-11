<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Question;

use Doctrine\Common\Collections\ArrayCollection;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class QuestionTest extends TestCase
{
    const TTLE = "Some arbitrary title.";
    
    const BODY = "Some arbitrary question text ...";
    /**
     *
     * @var Question
     */
    private $question;
    
    public function setUp()
    {
        $this->question = new Question();
    }
    
    public function testConstructor()
    {
        $question = new Question();
        $this->assertTrue($question instanceof Question);
        $createdAt = $question->getCreatedAt();
        $this->assertTrue(is_numeric($createdAt) && $createdAt > 0);
        $answers = $question->getAnswers();
        $comments = $question->getComments();
        $this->assertTrue($answers instanceof ArrayCollection);
        $this->assertTrue($comments instanceof ArrayCollection);
        $id = $question->getId();
        $this->assertTrue($id instanceof Uuid);
    }
    
    public function testGetId()
    {
        $id = $this->question->getId();
        $this->assertTrue($id instanceof Uuid);
    }
    
    public function testGetTitle()
    {
        $this->question->setTitle(self::TTLE);
        $this->assertEquals($this->question->getTitle(), self::TTLE);
    }
    
    public function testGetBody()
    {
        $this->question->setBody(self::BODY);
        $this->assertEquals($this->question->getBody(), self::BODY);
    }
    
    
}
