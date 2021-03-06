<?php

namespace AppBundle\View;


class AuthorView
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
    private $name;
    
    /**
     *
     * @var string
     */
    private $surname;
    
    /**
     * @param string $id
     * @param string $name
     * @param string $surname
     */
    public function __construct($id, $name, $surname)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
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

    /**
     * 
     * @return string
     */
    public function getNameLabel()
    {
        $label = "%s %s";
        return sprintf($label, $this->name, $this->surname);
    }
}
