<?php

namespace AppBundle\View;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @var AnswerView[]
     */
    private $answers;
    
    /**
     *
     * @var AuthorView
     */
    private $author;
    
    /**
     *
     * @var CommentView[]
     */
    private $comments;
    
    /**
     *
     * @var int
     */
    private $createdAt;
    
    /**
     *
     * @var int
     */
    private $answersCount;
    
    /**
     *
     * @var int
     */
    private $votes;
    
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
        $this->answers = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getAnswers(): array {
        return $this->answers->toArray();
    }

    public function addAnswer(AnswerView $answer) {
        $this->answers->add($answer);
    }
    
    public function getAuthor(): AuthorView {
        return $this->author;
    }

    public function getComments(): array {
        return $this->comments->toArray();
    }

    public function addComment(CommentView $comment)
    {
        $this->comments->add($comment);
    }
    
    public function setAuthor(AuthorView $author) {
        $this->author = $author;
        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }
    
    public function getAnswersCount() {
        return $this->answersCount;
    }

    /**
     * 
     * @param int $answersCount
     * @return $this
     */
    public function setAnswersCount($answersCount) {
        $this->answersCount = $answersCount;
        return $this;
    }
    
    public function getVotes() {
        return $this->votes;
    }

    public function setVotes($votes) {
        $this->votes = $votes;
        return $this;
    }
}
