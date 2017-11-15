<?php
namespace AppBundle\Service\Application;

use AppBundle\Form\Model\Question as FormQuestion;
use AppBundle\Entity\Question;

class QuestionService
{
    public function populateQuestion(Question $question, FormQuestion $formQuestion)
    {
        $question->setTitle($formQuestion->getTitle())
                ->setBody($formQuestion->getBody());
    }
}
