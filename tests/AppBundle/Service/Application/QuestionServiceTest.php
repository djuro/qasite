<?php

namespace Tests\AppBundle\Service\Application;

use AppBundle\Entity\Question;
use AppBundle\Form\Model\Question as FormQuestion;

use PHPUnit\Framework\TestCase;

class QuestionServiceTest extends TestCase
{
    
    const TITLE = "Some title ...";
    
    const BODY = "Some body text ...";
    
    
    /**
     * @param FormQuestion $formQuestion
     * @dataProvider providerForTestTransformFormQuestion
     */
    public function testTransformFormQuestion(Question $question, FormQuestion $formQuestion) {
        
        $questionService = $this->getMockBuilder('AppBundle\Service\Application\QuestionService')
                                ->disableOriginalConstructor()
                                ->setMethods(null)
                                ->getMock();
        $question = $questionService->transformFormQuestion($question, $formQuestion);
        $this->assertTrue($question instanceof Question);
    }
    
    /**
     * 
     * @return FormQuestion[]
     */
    public function providerForTestTransformFormQuestion() {
        $question = new Question();
        $formQuestion = new FormQuestion();
        $formQuestion->setTitle(self::TITLE)
                ->setBody(self::BODY);
        return array(
            array($question, $formQuestion)
        );
    }
}
