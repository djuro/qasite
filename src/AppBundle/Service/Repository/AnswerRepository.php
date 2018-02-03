<?php

namespace AppBundle\Service\Repository;

use AppBundle\Entity\Answer;

use Doctrine\ORM\EntityManager;


class AnswerRepository
{
   /**
    *
    * @var EntityManager
    */
   private $em;
   
   /**
    * 
    * @param EntityManager $em
    */
   public function __construct(EntityManager $em)
   {
       $this->em = $em;
   }
   
   
   public function persist(Answer $answer)
   {
       $this->em->persist($answer);
   }
   
   public function flush()
   {
       $this->em->flush();
   }
   
   public function findAll()
   {
       $qb = $this->em->createQueryBuilder()
               ->select('A')
               ->from('AppBundle:Answer', 'A');
       $query = $qb->getQuery();
       return $query->getResult();
   }
}
