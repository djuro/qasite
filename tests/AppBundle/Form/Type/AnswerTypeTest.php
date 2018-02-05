<?php

namespace Tests\AppBundle\Form\Type;

use AppBundle\Form\Type\AnswerType;
use AppBundle\Form\Model\Answer;

use Symfony\Component\Form\Test\TypeTestCase;

class AnswerTypeTest extends TypeTestCase
{
    const BODY = "This is some answer body text ...";
    
    /**
     * @dataProvider providerForAnswer
     */
    public function testSubmitValidData(Answer $answer)
    {
        $formData = array(
            'body' => self::BODY,
        );
        
        
        $form = $this->factory->create(AnswerType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        
        $this->assertEquals($answer, $form->getData());
        
        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
    
    public function providerForAnswer()
    {
        $answer = new Answer;
        $answer->setBody(self::BODY);
        return array(
            array($answer)
        );
    }
}
