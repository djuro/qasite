<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AnswerComment extends Comment
{
    /**
     *
     * @var Answer
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="comments")
     * @ORM\JoinColumn(name="answer", referencedColumnName="id")
     */
    private $answer;
    
    /**
     * 
     * @return Answer
     */
    public function getAnswer() {
        return $this->answer;
    }

    /**
     * 
     * @param Answer $answer
     * @return $this
     */
    public function setAnswer(Answer $answer) {
        $this->answer = $answer;
        return $this;
    }


}
