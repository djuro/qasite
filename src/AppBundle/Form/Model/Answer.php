<?php

namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Answer
{
    /**
     *
     * @var string
     * @Assert\NotBlank(message="Body text is required.")
     */
    private $body;
    
    public function getBody() {
        return $this->body;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }


}
