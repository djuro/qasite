<?php
namespace Tests\AppBundle\Service\Repository;

use AppBundle\Entity\Answer;
use AppBundle\Service\Repository\AnswerRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AnswerRepositoryTest extends WebTestCase
{
    /**
     * @var AnswerRepository
     */
    private $answerRepository;
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->answerRepository = static::$kernel->getContainer()->get('qasite.answer_repository');
    }
    
    public function testConstructor()
    {
        $this->assertTrue($this->answerRepository instanceof AnswerRepository);
    }
    
    public function testFindAll()
    {
        $storedAnswers = $this->answerRepository->findAll();
        $this->assertTrue(is_array($storedAnswers));
        $this->assertTrue($storedAnswers[0] instanceof Answer);
    }
}
