<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Question;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;

use \Kint;

class QuestionControllerTest extends WebTestCase
{
    const TITLE = "Some test question title ...";
    
    const BODY = "Some test body text ...";
    
    private $client;
 
    private $questionRepository;
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        
        $this->client = static::createClient();
        $this->questionRepository = static::$kernel->getContainer()->get('qasite.question_repository');
    }
    
    public function testNewAction() {
        $this->logIn();
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', 'question/new');
        
        //d($this->client->getResponse()->getContent());
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
        //d($route);
        //d($this->client->getContainer()->get('sensio_framework_extra.converter.doctrine.orm'));
        //exit;
        //d($this->client->getRequest());
        $crawler = $this->client->request('GET', $route);
        //d($this->client->getResponse()->getContent());
        //d($this->client->getRequest());
        //$this->client->getRequest()->getAttributes()->set('question', $question);
        
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
    
    public function providerForTestEdit()
    {
       //$testQuestion =  
    }
    
//    private function logIn()
//    {
//        $session = $this->client->getContainer()->get('session');
//        $firewallContext = 'main';
//
//        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_ADMIN'));
//        $session->set('_security_'.$firewallContext, serialize($token));
//        $session->save();
//
//        $cookie = new Cookie($session->getName(), $session->getId());
//        $this->client->getCookieJar()->set($cookie);
//    }
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
    
    /**
     * 
     * @return Question
     */
    private function findQuestion() {
        
        $questions = $this->questionRepository->findAll();
        
        return $questions[0];
    }

}
