<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\Model\Question;
use AppBundle\Form\Type\QuestionType;

use Symfony\Component\Form\Test\TypeTestCase;

class QuestionTypeTest extends TypeTestCase
{
    const TITLE = "A question title";
    
    const BODY = "Some interesting question body text.";
    
    /**
     * 
     * @dataProvider providerForQuestion
     */
    public function testSubmitValidData(Question $question)
    {
        $formData = array(
            'title' => self::TITLE,
            'body' => self::BODY,
        );
        
        $form = $this->factory->create(QuestionType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        
        $this->assertEquals($question, $form->getData());
        
        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
    
    public function providerForQuestion()
    {
        $question = new Question;
        $question->setBody(self::BODY)
                ->setTitle(self::TITLE);
        return array(
            array($question)
        );
    }
}
