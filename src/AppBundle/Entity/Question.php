<?php
namespace AppBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use \Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="question")
 */
class Question
{
    /**
     * 
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * 
     * @var string
     * @ORM\Column(type="text")
     */
    private $body;
   
    /**
     *
     * @var Answer
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $answers;
    
    /**
     *
     * @var QuestionComment[]
     * @ORM\OneToMany(targetEntity="QuestionComment", mappedBy="question")
     */
    private $comments;
    
    /**
     *
     * @var User
     */
    private $author;
   
    /**
     *
     * @var int
     * @ORM\Column(type="integer", name="created_at")
     */
    private $createdAt;
    
    /**
     *
     * @var int
     * @ORM\Column(type="integer", name="updated_at")
     */
    private $updatedAt;
    
    
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = time();
        $this->comments = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }


    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * 
     * @param QuestionComment $comment
     */
    public function addComment(QuestionComment $comment)
    {
        $comment->setQuestion($this);
        $this->comments->add($comment);
    }
    
    /**
     * 
     * @param QuestionComment $comment
     */
    public function removeComment(QuestionComment $comment)
    {
        $comment->removeQuestion();
        $this->comments->removeElement($comment);
    }
    
    /**
     * 
     * @param Answer $answer
     */
    public function addAnswer(Answer $answer)
    {
        $answer->setQuestion($this);
        $this->answers->add($answer);
    }
    
    /**
     * 
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        $answer->removeQuestion();
        $this->answers->removeElement($answer);
    }
    
    /**
     * 
     * @return QuestionComment[]
     */
    public function getComments() {
        return $this->comments;
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
    
    /**
     * 
     * @return Answer[]
     */
    public function getAnswers() {
        return $this->answers;
    }
    
    /**
     * 
     * @return int
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }
    
    /**
     * @return int
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    /**
     * 
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }
    
    /**
     * 
     * @param int $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}

