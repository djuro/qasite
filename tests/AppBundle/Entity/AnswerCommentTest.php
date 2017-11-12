<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Answer;
use AppBundle\Entity\AnswerComment;

use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;

class AnswerCommentTest extends TestCase
{
    public function testSetGetAnswer()
    {
        $answer = new Answer();
        $answerComment = new AnswerComment();
        $answer->addComment($answerComment);
        $this->assertTrue($answerComment->getAnswer() === $answer);
    }
}
