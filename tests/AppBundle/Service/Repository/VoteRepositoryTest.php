<?php

namespace Tests\AppBundle\Service\Repository;

use AppBundle\Entity\UpVote;
use AppBundle\Entity\DownVote;
use AppBundle\Entity\Question;
use AppBundle\Service\Repository\VoteRepository;
use AppBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use \Exception;
use \StdClass;

class VoteRepositoryTest extends WebTestCase {
    
    const TITLE = "Some title ...";
    
    const BODY = "Some q. body text ...";
    
    const INVALID_TEST_USER_MSG = "Test User not found. It should be created in test database for tests to work.";
    /**
     *
     * @var User
     */
    private $user;
    
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
        $this->user = $this->em->getRepository('AppBundle:User')->findOneBy(array('username'=>'testuser'));
        if(!$this->user instanceof User)
            throw new Exception(self::INVALID_TEST_USER_MSG);
    }
    
    /**
     * @dataProvider providerForTestStoreUpvote
     */
    public function testStoreUpvote(Question $question)
    {   
        $this->em->persist($question);
        $upVote = new UpVote($this->user, $question);
        
        $this->voteRepository->storeUpVote($upVote);
        $this->voteRepository->emFlush();
        
        $upVoteStored = $this->em
                ->getRepository('AppBundle:UpVote')
                ->findOneBy(array('question'=>$question, 'user'=>$this->user));
        
        $this->assertTrue($upVoteStored === $upVote);
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestStoreUpvote
     */
    public function testFindUpvotesFor(Question $question)
    {
        $this->upvoteQuestion($question);
        
        $upvotes = $this->voteRepository->findUpvotesFor($question);
        $this->assertTrue(count($upvotes)>0);
    }
    
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestStoreUpvote
     */
    public function testFindDownvotesFor(Question $question)
    {
        $this->downvoteQuestion($question);
        
        $downvotes = $this->voteRepository->findDownvotesFor($question);
        $this->assertTrue(count($downvotes)>0);
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
    
    public function providerForTestFindIfUpvotedBy()
    {
        $question = new Question();
        $question->setTitle(self::TITLE)
                ->setBody(self::BODY);
        
        return array(
            array($question)
            );
    }
    
    /**
     * 
     * @param Question $question
     */
    private function upvoteQuestion(Question $question)
    {
        $this->em->persist($question);
        $upVote = new UpVote($this->user, $question);
        
        $this->voteRepository->storeUpVote($upVote);
        $this->voteRepository->emFlush();
    }
    
    /**
     * 
     * @param Question $question
     */
    private function downvoteQuestion(Question $question)
    {
        $this->em->persist($question);
        $downVote = new DownVote($this->user, $question);
        
        $this->voteRepository->storeDownVote($downVote);
        $this->voteRepository->emFlush();
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestStoreUpvote
     */
    public function testFindIfUpvotedBy(Question $question)
    {
        $this->em->persist($question);
        $upvoted = $this->voteRepository->findIfUpvotedBy($question, $this->user);
        // Positive outcome first covered with tests: QuestionVoteControllerTest::testUpvoteAction and 
        // testDownVoteAction and by other methods in this class.
        $this->assertTrue(FALSE === $upvoted);
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestStoreUpvote
     */
    public function testFindIfDownvotedBy(Question $question)
    {
        $this->em->persist($question);
        $downvoted = $this->voteRepository->findIfDownvotedBy($question, $this->user);
        // Positive outcome first covered with tests: QuestionVoteControllerTest::testUpvoteAction and 
        // testDownVoteAction and by other methods in this class.
        $this->assertTrue(FALSE === $downvoted);
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestFindIfUpvotedBy
     */
    public function testRemoveUpvoteFor(Question $question)
    {
        $this->em->persist($question);
        $this->upvoteQuestion($question);
        $upvotedTrue = $this->voteRepository->findIfUpvotedBy($question, $this->user);
        $this->assertTrue($upvotedTrue === TRUE);
        
        $this->voteRepository->removeUpvoteFor($question, $this->user);
        $this->voteRepository->emFlush();
        $upvotedFalse = $this->voteRepository->findIfUpvotedBy($question, $this->user);
        $this->assertTrue(FALSE === $upvotedFalse);
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestFindIfUpvotedBy
     */
    public function testRemoveDownvoteFor(Question $question)
    {
        $this->em->persist($question);
        $this->downvoteQuestion($question);
        $downvotedTrue = $this->voteRepository->findIfDownvotedBy($question, $this->user);
        $this->assertTrue($downvotedTrue === TRUE);
        
        $this->voteRepository->removeDownvoteFor($question, $this->user);
        $this->voteRepository->emFlush();
        
        $downvotedFalse = $this->voteRepository->findIfDownvotedBy($question, $this->user);
        $this->assertTrue(FALSE === $downvotedFalse);
    }
}

