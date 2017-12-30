<?php
namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Question;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class QuestionVoteControllerTest  extends WebTestCase
{
    private $client;

    private $questionRepository;
    
    public function setUp()
    {
        
        $this->client = static::createClient();
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->questionRepository = static::$kernel->getContainer()->get('qasite.question_repository');
    }
    /**
     * 
     * @dataProvider providerForTestUpVote
     */
    public function testUpVoteAction(Question $question)
    {
        $this->logIn();
        //$this->client->followRedirects(true);
        
        $questionId = $question->getId();
        $crawler = $this->client->request('GET', 'upvote/question/'.$questionId);
        d($this->client->getResponse()->getStatusCode()); exit;
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Ask Question")')->count()
        );
    }
    
    
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
    
    public function providerForTestUpVote()
    {
        $question = new Question();
        $this->questionRepository->persist($question);
        $this->questionRepository->emFlush();
        return array(
            array($question)
        );
    }
}
