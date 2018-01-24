<?php

namespace AppBundle\View;


class AnswerView
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
     * @var CommentView[]
     */
    private $comments;
    
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
}
