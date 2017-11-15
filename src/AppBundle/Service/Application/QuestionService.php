<?php
namespace AppBundle\Service\Application;

use AppBundle\Form\Model\Question as FormQuestion;
use AppBundle\Entity\Question;

class QuestionService
{
    /**
     * 
     * @param FormQuestion $formQuestion
     * @return Question
     */
    public function transformFormQuestion(FormQuestion $formQuestion):Question
    {
        $question = new Question();
        $question->setTitle($formQuestion->getTitle())
                ->setBody($formQuestion->getBody());
        return $question;
    }
}
