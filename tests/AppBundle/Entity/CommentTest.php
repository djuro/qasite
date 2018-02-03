<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Comment;

use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\User;

class CommentTest extends TestCase
{
    const BODY = "Some text ...";
    
    const USRNM = "someusername";
    
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
    
    public function testSetGetAuthor()
    {
        $author = new User();
        $author->setUsername(self::USRNM);
        $this->comment->setAuthor($author);
        
        $this->assertTrue($author === $this->comment->getAuthor());
    }
}
