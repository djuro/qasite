<?php

namespace AppBundle\Form\Model;


use Symfony\Component\Validator\Constraints as Assert;

class Question
{
    /**
     *
     * @var string
     * @Assert\NotBlank(message="Question title is mandatory.")
     */
    private $title;
    
    /**
     *
     * @var string
     * @Assert\NotBlank(message="Question text is mandatory.")
     */
    private $body;
    
    public function getTitle() {
        return $this->title;
    }

    public function getBody() {
        return $this->body;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

}
