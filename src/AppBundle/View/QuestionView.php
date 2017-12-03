<?php

namespace AppBundle\View;

/**
 * DTO for Question entity.
 */
class QuestionView
{
    /**
     *
     * @var string
     */
    private $id;
    
    /**
     *
     * @var string
     */
    private $title;
    
    /**
     *
     * @var string
     */
    private $body;
    
    /**
     *
     * @var int
     */
    private $score;
    
    /**
     * 
     * @param string $id
     * @param string $title
     * @param string $body
     */
    public function __construct($id, $title, $body)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getBody() {
        return $this->body;
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($score) {
        $this->score = $score;
        return $this;
    }


}
