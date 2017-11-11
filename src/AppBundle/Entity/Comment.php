<?php
namespace AppBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use \Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"answer_comment" = "AnswerComment", "question_comment" = "QuestionComment"})
 */
abstract class Comment
{
    /**
     *
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;
    
    /**
     *
     * @var string
     * @ORM\Column(type="text")
     */
    protected $body;
    
    /**
     *
     * @var int
     * @ORM\Column(type="integer", name="created_at")
     */
    protected $createdAt;
    
    /**
     *
     * @var User
     */
    protected $author;
    
    
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = time();
    }
    
    /**
     * 
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * 
     * @return string
     */
    public function getBody() {
        return $this->body;
    }
    
    /**
     * 
     * @return int
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }
    
    /**
     * 
     * @param string $body
     * @return $this
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }
    
   
    /**
     * 
     * @return User
     */
    public function getAuthor() {
        return $this->author;
    }
    
    /**
     * 
     * @param User $author
     * @return $this
     */
    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }


}
