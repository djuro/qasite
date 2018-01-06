<?php

namespace Tests\AppBundle\Service\Repository;

use AppBundle\Entity\UpVote;
use AppBundle\Entity\Question;
use AppBundle\Service\Repository\VoteRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VoteRepositoryTest extends WebTestCase {
    
    const TITLE = "Some title ...";
    
    const BODY = "Some q. body text ...";
    
    
    /**
     *
     * @var EntityManager
     */
    private $em;
    
    /**
     *
     * @var VoteRepository
     */
    private $voteRepository;
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->voteRepository = static::$kernel->getContainer()->get('qasite.vote_repository');
    }
    
    /**
     * @dataProvider providerForTestStoreUpvote
     */
    public function testStoreUpvote(Question $question)
    {   
        $this->em->persist($question);
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(array('username'=>'testuser'));
        $upVote = new UpVote($user, $question);
        
        $this->voteRepository->storeUpVote($upVote);
        $this->voteRepository->emFlush();
        
        $upVoteStored = $this->em
                ->getRepository('AppBundle:UpVote')
                ->findOneBy(array('question'=>$question, 'user'=>$user));
        
        $this->assertTrue($upVoteStored === $upVote);
    }
    
    public function providerForTestStoreUpvote()
    {
        $question = new Question();
        $question->setTitle(self::TITLE)
                ->setBody(self::BODY);
        
        return array(
            array($question)
            );
    }
}
