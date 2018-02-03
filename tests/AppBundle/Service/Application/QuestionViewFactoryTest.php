<?php

namespace Tests\AppBundle\Service\Application;

use AppBundle\Entity\Question;
use AppBundle\View\QuestionView;
use AppBundle\Entity\User;
use AppBundle\Entity\QuestionComment;
use AppBundle\Entity\Answer;

use PHPUnit\Framework\TestCase;


class QuestionViewFactoryTest extends TestCase
{
    const TTLE = "Some fancy title ...";
    
    const BDY = "Some shiny new body ...";
    
    private $questionViewFactory;
    
    
    public function setUp()
    {   
        $questionService = $this->getMockBuilder('AppBundle\Service\Application\QuestionService')
                ->disableOriginalConstructor()
                ->getMock();
        
        $answerViewFactory = $this->getMockBuilder('AppBundle\Service\Application\AnswerViewFactory')
                ->disableOriginalConstructor()
                ->getMock();
        
        $this->questionViewFactory = $this->getMockBuilder('AppBundle\Service\Application\QuestionViewFactory')
                ->setConstructorArgs(array($questionService, $answerViewFactory))
                ->setMethods(NULL)
                ->getMock();
        
    }
    
    /**
     * @dataProvider providerForTestCreate
     */
    public function testCreateFromQuestion(Question $question)
    {
        $questionView = $this->questionViewFactory->createFromQuestion($question);
        $this->assertTrue($questionView instanceof QuestionView);
    }
    
    /**
     * @dataProvider providerForTestCreate
     */
    public function testCreateFrom($question)
    {
        $questionViews = $this->questionViewFactory->createFrom(array($question));
        $this->assertTrue(is_array($questionViews));
        $this->assertTrue($questionViews[0] instanceof QuestionView);
    }
    
    /**
     * 
     * @return Question[]
     */
    public function providerForTestCreate()
    {
        $question = new Question();
        $question->setTitle(self::TTLE)
                ->setBody(self::BDY)
                ->setAuthor(new User());
        $comment = new QuestionComment();
        $comment->setAuthor(new User());
 
        $question->addComment($comment);
        
        $answer = new Answer($question, new User());
        $answer->setBody(self::BDY);
        return array(
            array($question)
        );
    }
}
