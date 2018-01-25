<?php

namespace AppBundle\View;

use Doctrine\Common\Collections\ArrayCollection;

class AnswerView
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
    private $body;
    
    /**
     *
     * @var int
     */
    private $createdAt;
    
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
     * @param string $id
     * @param string $body
     * @param int $createdAt
     */
    public function __construct($id, $body, $createdAt)
    {
        $this->id = $id;
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->comments = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function addComment(CommentView $comment) {
        $this->comments->add($comment);
    }

    public function getBody() {
        return $this->body;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getAuthor(): AuthorView {
        return $this->author;
    }

    public function getComments(): array {
        return $this->comments->toArray();
    }
    
    public function setAuthor(AuthorView $author) {
        $this->author = $author;
        return $this;
    }
}
