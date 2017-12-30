<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\UpVote;
use AppBundle\Entity\User;
use AppBundle\Entity\Question;

use PHPUnit\Framework\TestCase;

class UpVoteTest extends TestCase
{
    public function testConstructor()
    {
        $question = new Question();
        $user = new User();
        $upVote = new UpVote($user, $question);
        $this->assertTrue($upVote->getQuestion() instanceof Question);
        $this->assertTrue($upVote->getUser() instanceof $user);
    }
}
