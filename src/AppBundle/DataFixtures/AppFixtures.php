<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use AppBundle\Entity\Question;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const BODY = "Some arbitrary text as answer body ...";
    
    const TITLE = "Some title text";
    
    const EMAIL = 'testuser@testenv.com';
    
    const USRNM = 'testuser';
    
    const ROLE_ADMIN = 'ROLE_ADMIN';
    
    const NAME = 'Walther';
    
    const SRNM = 'White';
    
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername(self::USRNM)
                ->setUsernameCanonical(self::USRNM)
                ->setEmail(self::EMAIL)
                ->setEmailCanonical(self::EMAIL)
                ->setEnabled(TRUE)
                ->setPassword(self::USRNM)
                ->setRoles([self::ROLE_ADMIN])
                ->setName(self::NAME)
                ->setSurname(self::SRNM);
        
        // create 20 products! Bam!
//        for ($i = 0; $i < 20; $i++) {
//            $product = new Product();
//            $product->setName('product '.$i);
//            $product->setPrice(mt_rand(10, 100));
//            $manager->persist($product);
//        }
        $question = $this->createQuestion();
        $question->setAuthor($user);
        $manager->persist($user);
        $manager->persist($question);
        $manager->flush();
    }
    
    /**
     * 
     * @return Question
     */
    private function createQuestion() {
        $question = new Question();
        $question->setTitle(self::TITLE)
                ->setBody(self::BODY);
        return $question;
    }
}
