<?php

namespace Tests\AppBundle\Service\Repository;

use AppBundle\Service\Repository\CommentRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentRepositoryTest extends WebTestCase
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;
    
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->commentRepository = static::$kernel->getContainer()->get('qasite.comment_repository');
    }
    
    public function testConstructor()
    {
        $this->assertTrue($this->commentRepository instanceof CommentRepository);
    }
}
