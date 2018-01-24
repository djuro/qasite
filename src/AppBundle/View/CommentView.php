<?php

namespace AppBundle\View;


class CommentView
{   
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
     * @param string $body
     * @param int $createdAt
     * @param AuthorView $author
     */
    public function __construct($body, $createdAt, AuthorView $author)
    {
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->author = $author;
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

}
