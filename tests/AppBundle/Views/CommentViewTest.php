<?php

namespace Tests\AppBundle\View;

use AppBundle\View\CommentView;
use AppBundle\View\AuthorView;

use PHPUnit\Framework\TestCase;

class CommentViewTest extends TestCase
{
    
    const ID = "abc-123-def";
    
    const BODY = "Shiny new body.";
    
    const TIME = "123456789";
    
    const NAME = "Walther";
    
    const SRNM = "White";
    
    /**
     * @dataProvider providerForCommentView
     */
    public function testConstructor(CommentView $commentView)
    {
        $this->assertTrue($commentView instanceof CommentView);
    }
    
    /**
     * @dataProvider providerForCommentView
     */
    public function testGetBody(CommentView $commentView)
    {
        $this->assertTrue($commentView->getBody() == self::BODY);
    }
    
    /**
     * @dataProvider providerForCommentView
     */
    public function testGetCreatedAt(CommentView $commentView)
    {
        $this->assertTrue($commentView->getCreatedAt() == self::TIME);
    }
    
    /**
     * @dataProvider providerForCommentView
     */
    public function testGetAuthor(CommentView $commentView)
    {
        $this->assertTrue($commentView->getAuthor() == $this->createAuthorView());
    }
    
    /**
     * 
     * @return CommentView[]
     */
    public function providerForCommentView()
    {
        $commentView = new CommentView(self::BODY, self::TIME, $this->createAuthorView());
        return array(
            array($commentView)
        );
    }
    
    /**
     * 
     * @return AuthorView[]
     */
    public function createAuthorView()
    {
        $view = new AuthorView(self::ID, self::NAME, self::SRNM);
        return $view;
    }
}
