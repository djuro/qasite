<?php

namespace Tests\AppBundle\View;

use AppBundle\View\QuestionView;
use AppBundle\View\AnswerView;
use AppBundle\View\AuthorView;
use AppBundle\View\CommentView;

use PHPUnit\Framework\TestCase;

class QuestionViewTest extends TestCase
{
    const ID = "abc-123-def";
    
    const BODY = "Shiny new body.";
    
    const TIME = "123456789";
    
    const NAME = "Walther";
    
    const SRNM = "White";
    
    const TITLE = "Some fancy title ...";
    
    const SCORE = 10;
    
    const VOTES = 2;
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testConstructor(QuestionView $questionView)
    {
        $this->assertTrue($questionView instanceof QuestionView);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testGetId(QuestionView $questionView)
    {
        $this->assertTrue($questionView->getId() == self::ID);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testGetTitle(QuestionView $questionView)
    {
        $this->assertTrue($questionView->getTitle() == self::TITLE);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testGetBody(QuestionView $questionView)
    {
        $this->assertTrue($questionView->getBody() == self::BODY);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testSetGetScore(QuestionView $questionView)
    {
        $questionView->setScore(self::SCORE);
        $this->assertTrue($questionView->getScore() === self::SCORE);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testAddGetAnswers(QuestionView $questionView)
    {
        $answerView = new AnswerView(self::ID, self::BODY, self::TIME);
        $questionView->addAnswer($answerView);
        $this->assertTrue($questionView->getAnswers()[0] === $answerView);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testSetGetAuthor(QuestionView $questionView)
    {
        $authorView = $this->createAuthorView();
        $questionView->setAuthor($authorView);
        $this->assertTrue($questionView->getAuthor() === $authorView);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testSetGetCreatedAt(QuestionView $questionView)
    {
        $questionView->setCreatedAt(self::TIME);
        $this->assertTrue($questionView->getCreatedAt() === self::TIME);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testAddGetComments(QuestionView $questionView)
    {
        $commentView = $this->createCommentView();
        $questionView->addComment($commentView);
        $this->assertTrue($questionView->getComments()[0] === $commentView);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testSetGetAnswerCount(QuestionView $questionView)
    {
        $questionView->setAnswersCount(self::SCORE);
        $this->assertTrue($questionView->getAnswersCount() === self::SCORE);
    }
    
    /**
     * @dataProvider providerForQuestionView
     */
    public function testSetGetVotes(QuestionView $questionView)
    {
        $questionView->setVotes(self::VOTES);
        $this->assertTrue($questionView->getVotes() === self::VOTES);
    }
    /**
     * @return QuestionView
     */
    public function providerForQuestionView()
    {
        $questionView = new QuestionView(self::ID, self::TITLE, self::BODY);
        return array(
            array($questionView)
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
    
    /**
     * 
     * @return CommentView
     */
    public function createCommentView()
    {
        $commentView = new CommentView(self::BODY, self::TIME, $this->createAuthorView());
        return $commentView;
    }
}
