<?php

namespace AppBundle\Service\Repository;

use AppBundle\Entity\Question;

use Doctrine\Bundle\DoctrineBundle\Registry;

class QuestionRepository
{
    /**
     *
     * @var Registry
     */
    private $doctrine;
    
    /**
     *
     * @var EntityManager
     */
    private $em;
    
    /**
     * 
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine) {
        $this->doctrine = $doctrine;
    }
    
    public function setEntityManager() {
        $this->em = $this->doctrine->getManager();
    }
    
    public function persist(Question $question) {
        $this->em->persist($question);
    }
    
    public function emFlush() {
        $this->em->flush();
    }
}