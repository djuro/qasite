<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class QuestionComment extends Comment
{
    /**
     *
     * @var Question
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="comments")
     * @ORM\JoinColumn(name="question", referencedColumnName="id")
     */
    private $question;
    
    /**
     * 
     * @return Question
     */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * 
     * @param Question $question
     * @return $this
     */
    public function setQuestion(Question $question) {
        $this->question = $question;
        return $this;
    }

}
