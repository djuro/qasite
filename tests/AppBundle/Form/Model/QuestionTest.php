<?php

namespace Tests\AppBundle\Form\Model;

use AppBundle\Form\Model\Question;

use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    const TITLE = "A question title";
    
    const BODY = "Some interesting question body text.";
    
    /**
     * @dataProvider providerForQuestion
     */
    public function testSetGetTitle(Question $question)
    {
        $question->setTitle(self::TITLE);
        $this->assertTrue($question->getTitle() === self::TITLE);
    }
    
    /**
     * @dataProvider providerForQuestion
     */
    public function testSetGetBody(Question $question)
    {
        $question->setBody(self::BODY);
        $this->assertTrue($question->getBody() === self::BODY);
    }
    
    public function providerForQuestion()
    {
        $question = new Question;
        return array(
            array($question)
        );
    }
}
