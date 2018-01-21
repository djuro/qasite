<?php

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer', TextareaType::class, array('label'=>'Your answer:',
                'constraints'=>array(
                    new NotBlank(['message'=>'Answer text is mandatory.']
                            )))
                    );
    }
    
    
    
}
