<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionControllerTest extends WebTestCase
{
    const TITLE = "Some test question title ...";
    
    const BODY = "Some test body text ...";
    
    public function testNewAction() {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', 'question/new');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Ask Question")')->count()
        );
        
        $form = $crawler->selectButton('Post Question')->form();
        $form['question[title]'] = self::TITLE;
        $form['question[body]'] = self::BODY;
        
        $formSubmitCrawler = $client->submit($form);
        //d($client->getResponse()->getContent());
        //$formSubmitCrawler->
        $this->assertGreaterThan(0,
                $formSubmitCrawler->filter('html:contains("Questions")')->count());
 
    }
    
    public function testListAction()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', 'question/list');
        //d($crawler->filter('html:contains("div")')); exit;
        //d($client->getResponse()->getContent());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Questions")')->count()
        );
    }
}
