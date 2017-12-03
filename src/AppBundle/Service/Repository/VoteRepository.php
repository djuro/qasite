<?php

namespace AppBundle\Service\Repository;

use AppBundle\Entity\UpVote;
use AppBundle\Entity\Question;
use Symfony\Bridge\Doctrine\RegistryInterface;

class VoteRepository {
    
    /**
     *
     * @var RegistryInterface
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
    public function __construct(RegistryInterface $doctrine) {
        $this->doctrine = $doctrine;
    }
    
    public function setEntityManager() {
        $this->em = $this->doctrine->getManager();
    }
    
    /**
     * 
     * @param Upvote $upvote
     */
    public function storeUpvote(UpVote $upvote)
    {
        $this->em->persist($upvote);
    }
    
    public function emFlush()
    {
        $this->em->flush();
    }
    
    /**
     * 
     * @param Question $question
     * @return UpVote[]
     */
    public function findUpvotesFor(Question $question)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("V")
                ->from("AppBundle:UpVote", "V")
                ->where("V.question=:question")
                ->setParameter('question', $question);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    
    /**
     * 
     * @param Question $question
     * @return DownVote[]
     */
    public function findDownvotesFor(Question $question)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("V")
                ->from("AppBundle:DownVote", "V")
                ->where("V.question=:question")
                ->setParameter('question', $question);
        $query = $qb->getQuery();
        return $query->getResult();
    }
    
    public function findIfUpvotedBy($question, $user)
    {
        
    }
    
    public function findIfDownvotedBy($question, $user)
    {
        
    }
}
