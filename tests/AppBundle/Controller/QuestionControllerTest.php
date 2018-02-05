<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Question;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;


class QuestionControllerTest extends WebTestCase
{
    const TITLE = "Some test question title ...";
    
    const BODY = "Some test body text ...";
    
    const COMMENTMOJ = "Evo jednog lipog komentara";
    
    const ANSW_BODY = "This is some very smart answer text ...";
    
    const COMMENT = "A comment text. Another bunch of wise words ...";
    
    /**
     *
     * @var Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;
    
    
    
    /**
     *
     * @var AnswerRepository 
     */
    private $answerRepository;
    
    
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        
        $this->client = static::createClient();
        $this->answerRepository = static::$kernel->getContainer()->get('qasite.answer_repository');
    }
    
    public function testNewAction() {
        $this->logIn();
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', 'question/new');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Ask Question")')->count()
        );
        
        $form = $crawler->selectButton('Post Question')->form();
        $form['question[title]'] = self::TITLE;
        $form['question[body]'] = self::BODY;
        
        $formSubmitCrawler = $this->client->submit($form);
        $this->assertGreaterThan(0,
                $formSubmitCrawler->filter('html:contains("Questions")')->count());
 
    }
    
    public function testEditAction()
    {
        $question = $this->findQuestion();
 
        $this->logIn();
        $this->client->followRedirects(true);
        $route = sprintf("question/%s/edit", $question->getId());
        
        $crawler = $this->client->request('GET', $route);
        
        $this->assertGreaterThan(0,
                $crawler->filter('html:contains("Ask Question")')->count());
        
        $form = $crawler->selectButton('Save')->form();
        $form['question[title]'] = self::TITLE;
        $form['question[body]'] = self::BODY;
        
        $formSubmitCrawler = $this->client->submit($form);
        $this->assertGreaterThan(0,
                $formSubmitCrawler->filter('html:contains("Questions")')->count());
    }
    
    public function testListAction()
    {
        $this->logIn();
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', 'questions');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Questions")')->count()
        );
    }
    
    public function testQuestionViewAction()
    {
        $this->client->restart();
        $this->logIn();
        $question = $this->findQuestion();
        
        $this->client->followRedirects(true);
        $route = sprintf("question/%s/view", $question->getId());
        
        $crawler = $this->client->request('GET', $route);
        $htmlQuery = sprintf('html:contains("%s")', $question->getTitle());
        
        //d($this->client->getResponse()->getContent());
        $this->assertEquals(1,
                $crawler->filter('html:contains("Post your answer")')->count());
        $this->assertGreaterThan(0,
                $crawler->filter($htmlQuery)->count());
        
        $form = $crawler->selectButton('Post your answer')->form();
        $form['answer[body]'] = self::ANSW_BODY;
        $formSubmitCrawler = $this->client->submit($form);
        
        $this->assertEquals(1,
                $formSubmitCrawler->filter('html:contains("Post your answer")')->count());
    }
    
    public function testHomeAction()
    {
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', "/");
        $this->assertGreaterThan(0,
                $crawler->filter('html:contains("Questions")')->count());
    }
    
    
    
    private function logIn() {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';
        $person = self::$kernel->getContainer()->get('doctrine')->getRepository('AppBundle:User')->findOneByUsername('testuser');

        $token = new UsernamePasswordToken($person, null, $firewallContext, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
    
    /**
     * 
     * @return Question
     */
    private function findQuestion() {
        
        $answers = $this->answerRepository->findAll();
        
        $answer = $answers[0];
        return $answer->getQuestion();
    }

}
