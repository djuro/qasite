<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="vote_down")
 */
class VoteDown
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
}
