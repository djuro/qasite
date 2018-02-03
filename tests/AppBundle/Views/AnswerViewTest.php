<?php

namespace Tests\AppBundle\View;

use AppBundle\View\AnswerView;
use AppBundle\View\AuthorView;
use AppBundle\View\CommentView;

use PHPUnit\Framework\TestCase;

class AnswerViewTest extends TestCase
{
    const ID = "abc-123-def";
    
    const BODY = "Shiny new body.";
    
    const TIME = "123456789";
    
    const NAME = "Walther";
    
    const SRNM = "White";
    
    /**
     * @dataProvider providerForAnswerView
     */
    public function testConstructor(AnswerView $view)
    {
        $this->assertTrue($view instanceof AnswerView);
    }
    
    /**
     * @dataProvider providerForAnswerView
     */
    public function testGetId(AnswerView $view)
    {
        $this->assertTrue(self::ID === $view->getId());
    }
    
    /**
     * @dataProvider providerForAnswerView
     */
    public function testGetCreatedAt(AnswerView $view)
    {
        
        $this->assertTrue($view->getCreatedAt() == self::TIME);
    }
    /**
     * @dataProvider providerForAuthorView
     */
    public function testSetGetAuthor(AnswerView $view, AuthorView $authorView)
    {
        $view->setAuthor($authorView);
        $this->assertTrue($view->getAuthor() === $authorView);
    }
    
    /**
     * @dataProvider providerForCommentView
     */
    public function testAddGetComments(AnswerView $answerView, CommentView $commentView)
    {
        $answerView->addComment($commentView);
        $this->assertTrue(is_array($answerView->getComments()));
        $this->assertTrue($answerView->getComments()[0] === $commentView);
    }
    
    public function providerForAnswerView()
    {
        $view = new AnswerView(self::ID, self::BODY, self::TIME);
        return array(
            array($view)
        );
    }
    
    public function providerForAuthorView()
    {
        $answerView = new AnswerView(self::ID, self::BODY, self::TIME);
        $authorView = new AuthorView(self::ID, self::NAME, self::SRNM);
        return array(
            array($answerView, $authorView)
        );
    }
    
    public function providerForCommentView()
    {
        $answerView = new AnswerView(self::ID, self::BODY, self::TIME);
        $authorView = new AuthorView(self::ID, self::NAME, self::SRNM);
        $commentView = new CommentView(self::BODY, self::TIME, $authorView);
        return array(
            array($answerView, $commentView)
        );
    }
    
}
