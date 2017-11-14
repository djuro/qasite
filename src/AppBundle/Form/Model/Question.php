<?php

namespace AppBundle\Form\Model;


use Symfony\Component\Validator\Constraints as Assert;

class Question
{
    /**
     *
     * @var string
     * @Assert\NotBlank()
     */
    private $title;
    
    /**
     *
     * @var string
     * @Assert\NotBlank()
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
