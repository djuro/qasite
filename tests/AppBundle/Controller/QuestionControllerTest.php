<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class QuestionControllerTest extends WebTestCase
{
    const TITLE = "Some test question title ...";
    
    const BODY = "Some test body text ...";
    
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
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

}
