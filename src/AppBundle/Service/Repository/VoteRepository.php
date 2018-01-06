<?php

namespace AppBundle\Service\Repository;

use AppBundle\Entity\UpVote;
use AppBundle\Entity\DownVote;
use AppBundle\Entity\Question;
use AppBundle\Entity\User;

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
     * @param Upvote $upVote
     */
    public function storeUpvote(UpVote $upVote)
    {
        $this->em->persist($upVote);
    }
    
    public function emFlush()
    {
        $this->em->flush();
    }
    
    /**
     * 
     * @param DownVote
     */
    public function storeDownvote(DownVote $downVote)
    {
        $this->em->persist($downVote);
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
    
    /**
     * 
     * @param Question $question
     * @param User $user
     * @return boolean
     */
    public function findIfUpvotedBy(Question $question, User $user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("V")
                ->from("AppBundle:UpVote", "V")
                ->where("V.question=:question")
                ->andWhere("V.user=:user")
                ->setParameter('question', $question)
                ->setParameter('user', $user);
        $query = $qb->getQuery();
        $result = $query->getResult();
        if(is_array($result) && count($result) > 0) {
            if($result[0] instanceof UpVote) 
                return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 
     * @param Question $question
     * @param User $user
     * @return boolean
     */
    public function findIfDownvotedBy(Question $question, User $user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select("V")
                ->from("AppBundle:DownVote", "V")
                ->where("V.question=:question")
                ->andWhere("V.user=:user")
                ->setParameter('question', $question)
                ->setParameter('user', $user);
        $query = $qb->getQuery();
        $result = $query->getResult();
        if(is_array($result) && count($result) > 0) {
            if($result[0] instanceof DownVote) 
                return TRUE;
        }
        return FALSE;
    }
    
    /**
     * 
     * @param Question $question
     * @param User $user
     */
    public function removeUpvoteFor(Question $question, User $user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->delete("AppBundle:UpVote", "V")
            ->where("V.question=:question")
                ->andWhere("V.user=:user")
                ->setParameter('question', $question)
                ->setParameter('user', $user);
        $query = $qb->getQuery();
        $query->execute();
    }
    
    /**
     * 
     * @param Question $question
     * @param User $user
     */
    public function removeDownvoteFor(Question $question, User $user)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->delete("AppBundle:DownVote", "V")
            ->where("V.question=:question")
                ->andWhere("V.user=:user")
                ->setParameter('question', $question)
                ->setParameter('user', $user);
        $query = $qb->getQuery();
        $query->execute();
    }
}
