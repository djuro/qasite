<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="answer")
 */
class Answer
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
     * @ORM\Column(type="text")
     */
    private $body;
    
    /**
     *
     * @var int
     * @ORM\Column(type="integer", name="created_at")
     */
    private $createdAt;
    
    /**
     *
     * @var Comment
     * @ORM\OneToMany(targetEntity="AnswerComment", mappedBy="answer")
     */
    private $comments;
    
    /**
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;
    
    /**
     *
     * @var Question
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question", referencedColumnName="id")
     */
    private $question;
    
    
    public function __construct(Question $question, User $createdBy) {
        $this->id = Uuid::uuid4();
        $this->question = $question;
        $this->createdBy = $createdBy;
        $this->createdAt = time();
        $this->comments = new ArrayCollection();
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
     * @return AnswerComment[]
     */
    public function getComments() {
        return $this->comments;
    }
    /**
     * 
     * @return User
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }
    /**
     * 
     * @return Question
     */
    public function getQuestion() {
        return $this->question;
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
     * @param AnswerComment $comment
     */
    public function addComment(AnswerComment $comment)
    {
        $comment->setAnswer($this);
        $this->comments->add($comment);
    }
    
    /**
     * 
     * @param AnswerComment $comment
     */
    public function removeComment(AnswerComment $comment)
    {
        $comment->removeAnswer($this);
        $this->comments->removeElement($comment);
    }
    
    public function removeQuestion()
    {
        $this->question = null;
    }
    
    /**
     * 
     * @return string
     */
    public function getAuthorLabel() {
        $label = "%s %s";
        return sprintf($label, $this->createdBy->getName(),
                $this->createdBy->getSurname());
    }
}
