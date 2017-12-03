<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="down_vote")
 */
class DownVote
{
    /**
     *
     * @var string
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Question")
     */
    private $question;
    
    /**
     *
     * @var string
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;
    
    /**
     * 
     * @param User $user
     * @param Question $question
     */
    public function __construct(User $user, Question $question)
    {
        $this->user = $user;
        $this->question = $question;
    }
}
