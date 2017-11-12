<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Comment;

use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    const BODY = "Some text ...";
    
    /**
     *
     * @var Comment
     */
    private $comment;
    
    public function setUp()
    {
        $this->comment = $this->getMockBuilder('AppBundle\Entity\Comment')
                ->setMethods(NULL)
                ->getMock();
    }
    
    public function testConstructor()
    {
        $this->assertTrue($this->comment->getId() instanceof Uuid);
        $this->assertTrue(is_numeric($this->comment->getCreatedAt()));
        $this->assertTrue($this->comment->getCreatedAt() > 0);
    }
    
    public function testGetId()
    {
        $id = $this->comment->getId();
        $this->assertTrue($id instanceof Uuid);
    }
    
    public function testSetGetBody()
    {
        $this->comment->setBody(self::BODY);
        $this->assertEquals($this->comment->getBody(), self::BODY);
    }
}
