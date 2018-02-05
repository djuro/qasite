<?php

namespace Tests\AppBundle\Form\Model;

use AppBundle\Form\Model\Answer;

use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    
    const BODY = "An answer body text.";
    
    
    public function testSetGetBody()
    {
        $answer = new Answer();
        $answer->setBody(self::BODY);
        $this->assertTrue($answer->getBody() === self::BODY);
                
    }
}
