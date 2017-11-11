<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Question;
use AppBundle\Entity\QuestionComment;
use AppBundle\Entity\Answer;

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
    
    public function testAddComment()
    {
        $comment = new QuestionComment();
        $this->question->addComment($comment);
        $addedComment = $this->question->getComments()->first();
        $this->assertEquals($addedComment->getQuestion(), $this->question);
        $this->assertTrue($comment === $addedComment);
    }
    
    public function testRemoveComment()
    {
        $comment = new QuestionComment();
        $this->question->addComment($comment);
        $comments = $this->question->getComments()->toArray();
        $this->assertTrue(count($comments)==1);
        
        $this->question->removeComment($comment);
        $commentsEmptied = $this->question->getComments()->toArray();
        $this->assertTrue(count($commentsEmptied)==0);
    }
    
    public function testAddRemoveAnswer()
    {
        $answer = new Answer();
        $this->question->addAnswer($answer);
        $addedAnswer = $this->question->getAnswers()->first();
        $this->assertEquals($addedAnswer, $answer);
        
        $this->question->removeAnswer($answer);
        $answers = $this->question->getAnswers()->toArray();
        $this->assertTrue(count($answers) == 0);
    }
    
    public function testSetGetUpdatedAt()
    {
        $updatedAt = time();
        $this->question->setUpdatedAt($updatedAt);
        
        $this->assertTrue($updatedAt === $this->question->getUpdatedAt());
    }
    
}
