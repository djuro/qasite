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
    
    const ANSW_BODY = "This is some very smart answer text ...";
    
    const COMMENT = "A comment text. Another bunch of wise words ...";
    
    /**
     *
     * @var Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;
    
    /**
     *
     * @var AppBundle\Service\Repository\QuestionRepository
     */
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
        $question = $this->findQuestion();
        $this->client->followRedirects(true);
        $route = sprintf("question/%s/view", $question->getId());
        
        $crawler = $this->client->request('GET', $route);
        $htmlQuery = sprintf('html:contains("%s")', $question->getTitle());
        $this->assertGreaterThan(0,
                $crawler->filter($htmlQuery)->count());
        $this->assertEquals(0,
                $crawler->filter('html:contains("Post your answer")')->count());
        
        // test by another URL
        $this->logIn();
        $authenticatedCrawler = $this->client->request('GET', '/question/'.$question->getId().'/engage');
        $this->assertGreaterThan(0,
                $authenticatedCrawler->filter('html:contains("Post your answer")')->count());
        
        $form = $authenticatedCrawler->selectButton('Post your answer')->form();
        $form['answer[answer]'] = self::ANSW_BODY;
        $formSubmitCrawler = $this->client->submit($form);
        $this->assertGreaterThan(0,
                $formSubmitCrawler->filter('html:contains("'.self::ANSW_BODY.'")')->count());
    }
    
    public function testHomeAction()
    {
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', "/");
        $this->assertGreaterThan(0,
                $crawler->filter('html:contains("Questions")')->count());
    }
    
    public function testStoreQuestionCommentAction()
    {
        $question = $this->findQuestion();
        $this->logIn();
        $this->client->followRedirects(true);
        $authenticatedCrawler = $this->client->request('GET', '/question/'.$question->getId().'/engage');
        $links = $authenticatedCrawler->selectLink('add a comment');
        $links->first()->link();
        $this->assertGreaterThan(0,
            $authenticatedCrawler->filter('html:contains("Add Comment")')->count());
        $form = $authenticatedCrawler->selectButton('Add Comment')->form();
        $form['comment[comment]'] = self::COMMENT;
        $commentSubmittedCrawler = $this->client->submit($form);
        $this->assertGreaterThan(0,
            $commentSubmittedCrawler->filter('html:contains("'.$question->getTitle().'")')->count());
        //$crawler->selectLink('Click for Report')->link();
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
        
        $questions = $this->questionRepository->findAll();
        
        return $questions[0];
    }

}
