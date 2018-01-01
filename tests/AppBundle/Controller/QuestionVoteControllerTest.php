<?php
namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Question;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class QuestionVoteControllerTest  extends WebTestCase
{
    
    const TTLE = "Some fancy title ...";
    
    const BDY = "Some shiny fat body ...";
    
    /**
     *
     * @var Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    /**
     *
     * @var QuestionRepository
     */
    private $questionRepository;
    
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->questionRepository = static::$kernel->getContainer()->get('qasite.question_repository');
        $this->client = static::createClient();
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestUpVote
     */
    public function testUpVoteAction(Question $question)
    {
        $this->logIn();
        
        $this->questionRepository->persist($question);
        $this->questionRepository->emFlush();
        
        $questionId = $question->getId();
        $this->client->request('GET', 'upvote/question/'.$questionId,
                array(),
                array(),
                array(
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $statusCode = $this->client->getResponse()->getStatusCode();
        $score = $this->client->getResponse()->getContent(); 
                    
        $this->assertTrue($statusCode == 200);
        $this->assertTrue($score == 1);
        
        $this->client->restart();
        $this->logIn();
        $this->client->request('GET', 'upvote/question/'.$questionId,
                array(),
                array(),
                array(
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertTrue($this->client->getResponse()->getStatusCode() == 423);
        
        $this->client->restart();
        $this->logIn();
        $this->client->request('GET', 'upvote/question/'.$questionId);
        $this->assertTrue($this->client->getResponse()->getStatusCode() == 404);
        
    }
    
    /**
     * 
     * @param Question $question
     * @dataProvider providerForTestUpVote
     */
    public function testDownVoteAction(Question $question)
    {
        $this->logIn();
        
        $this->questionRepository->persist($question);
        $this->questionRepository->emFlush();
        
        $questionId = $question->getId();
        $this->client->request('GET', 'downvote/question/'.$questionId,
                array(),
                array(),
                array(
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $statusCode = $this->client->getResponse()->getStatusCode();
        $score = $this->client->getResponse()->getContent(); 
                    
        $this->assertTrue($statusCode == 200);
        $this->assertTrue($score == -1);
        
        $this->client->restart();
        $this->logIn();
        $this->client->request('GET', 'downvote/question/'.$questionId,
                array(),
                array(),
                array(
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'));
        $this->assertTrue($this->client->getResponse()->getStatusCode() == 423);
        
        $this->client->restart();
        $this->logIn();
        $this->client->request('GET', 'downvote/question/'.$questionId);
        $this->assertTrue($this->client->getResponse()->getStatusCode() == 404);
    }
    
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';
        $person = self::$kernel->getContainer()->get('doctrine')->getRepository('AppBundle:User')->findOneByUsername('testuser');

        $token = new UsernamePasswordToken($person, null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
    
    public function providerForTestUpVote()
    {
        $question = new Question();
        $question->setTitle(self::TTLE)
                ->setBody(self::BDY);
        return array(
            array($question)
        );
    }
}
