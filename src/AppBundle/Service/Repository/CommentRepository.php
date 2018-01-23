<?php

namespace AppBundle\Service\Repository;

use AppBundle\Entity\Comment;

use Doctrine\ORM\EntityManager;


class CommentRepository
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
   
   
   public function persist(Comment $comment)
   {
       $this->em->persist($comment);
   }
   
   public function flush()
   {
       $this->em->flush();
   }
}
