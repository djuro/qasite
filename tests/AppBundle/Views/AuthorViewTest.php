<?php

namespace Tests\AppBundle\View;

use AppBundle\View\AuthorView;

use PHPUnit\Framework\TestCase;

class AuthorViewTest extends TestCase
{
    
    const ID = "abc-123-def";
    
    const BODY = "Shiny new body.";
    
    const TIME = "123456789";
    
    const NAME = "Walther";
    
    const SRNM = "White";
    
    /**
     * 
     * @dataProvider providerForAuthorView
     */
    public function testConstructor(AuthorView $authorView)
    {
        $this->assertTrue($authorView instanceof AuthorView);
    }
    
    /**
     * 
     * @dataProvider providerForAuthorView
     */
    public function testGetId(AuthorView $authorView)
    {
        $this->assertTrue($authorView->getId() == self::ID);
    }
    
    /**
     * 
     * @dataProvider providerForAuthorView
     */
    public function testGetName(AuthorView $authorView)
    {
        $this->assertTrue($authorView->getName() == self::NAME);
    }
    
    /**
     * 
     * @dataProvider providerForAuthorView
     */
    public function testGetSurname(AuthorView $authorView)
    {
        $this->assertTrue($authorView->getSurname() == self::SRNM);
    }
    
    /**
     * 
     * @dataProvider providerForAuthorView
     */
    public function testGetNameLabel(AuthorView $authorView)
    {
        $nameLabel = sprintf("%s %s", self::NAME, self::SRNM);
        $this->assertTrue($nameLabel == $authorView->getNameLabel());
    }
    
    /**
     * 
     * @return AuthorView[]
     */
    public function providerForAuthorView()
    {
        $view = new AuthorView(self::ID, self::NAME, self::SRNM);
        return array(
            array($view)
        );
    }
}
