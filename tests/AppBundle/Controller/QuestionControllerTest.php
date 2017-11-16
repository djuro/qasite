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
        echo $client->getResponse()->getStatusCode();
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Ask Question")')->count()
        );
        
        $form = $crawler->selectButton('Post Question')->form();
        $form['question[title]'] = self::TITLE;
        $form['question[body]'] = self::BODY;
        
        $formSubmitCrawler = $client->submit($form);
        
        $this->assertGreaterThan(
            0,
            $formSubmitCrawler->filter('html:contains("Questions list")')->count()
        );
 
    }
}
