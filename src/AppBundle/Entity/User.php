<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;
    
    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=TRUE)
     */
    private $name;
    
    /**
     *
     * @var string
     * @ORM\Column(type="string", nullable=TRUE)
     */
    private $surname;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->id = Uuid::uuid4();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
        return $this;
    }


    
}
