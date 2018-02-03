<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class CommentFormAjaxControllerTest extends WebTestCase
{
    private $client;
    
    private $answerRepository;
    
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        //$this->questionRepository = static::$kernel->getContainer()->get('qasite.question_repository');
        $this->client = static::createClient();
        $this->answerRepository = static::$kernel->getContainer()->get('qasite.answer_repository');
    }
    
    public function testRenderQuestionCommentFormAction()
    {
        $question = $this->findQuestion();
        $this->logIn();
        $route = "/question/render-question-comment-form";
        $crawler = $this->client->request('POST', $route,
                array('question'=>$question->getId()),
                array(),
                array(
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'));
        
        $statusCode = $this->client->getResponse()->getStatusCode();
        $this->assertTrue($statusCode == 200);
               
        $this->assertGreaterThan(0,
                $crawler->filter('html:contains("Add Comment")')->count());
        
        $this->client->restart();
        $this->logIn();
        $this->client->request('GET', $route);
        $this->assertTrue($this->client->getResponse()->getStatusCode() == 404);
    }
    
    public function testRenderAnswerCommentFormAction()
    {
        $question = $this->findQuestion();
        $this->logIn();
        $route = "/question/render-answer-comment-form";
        $crawler = $this->client->request('POST', $route,
                array('answer'=>$question->getAnswers()->first()->getId(), 'question'=>$question->getId()),
                array(),
                array(
                    'HTTP_X-Requested-With' => 'XMLHttpRequest'));
        
        $statusCode = $this->client->getResponse()->getStatusCode();
        $this->assertTrue($statusCode == 200);
               
        $this->assertGreaterThan(0,
                $crawler->filter('html:contains("Add Comment")')->count());
        
        $this->client->restart();
        $this->logIn();
        $this->client->request('GET', $route);
        $this->assertTrue($this->client->getResponse()->getStatusCode() == 404);
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