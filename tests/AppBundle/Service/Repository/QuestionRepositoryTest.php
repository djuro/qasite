<?php

namespace Tests\AppBundle\Service\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Question;

class QuestionRepositoryTest extends WebTestCase
{
    const TITLE = "Some title ...";
    
    const BODY = "Some q. body text ...";
    
    /**
     *
     * @var QuestionRepository
     */
    private $questionRepository;
    
    /**
     *
     * @var EntityManager
     */
    private $em;
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->questionRepository = static::$kernel->getContainer()->get('qasite.question_repository');
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestFind
     */
    public function testFind(Question $question)
    {
        $questionId = $question->getId();
        $this->em->persist($question);
        $this->em->flush();
        $storedQuestion = $this->questionRepository->find($questionId);
        $this->assertTrue($question === $storedQuestion);
    }
    
    public function providerForTestFind()
    {
        $question = new Question();
        $question->setTitle(self::TITLE)
            ->setBody(self::BODY);
        return array(
            array($question)
            );
    }
}
