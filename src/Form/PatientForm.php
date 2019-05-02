<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => false])
            ->add('surname', TextType::class, ['label' => false])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'M' => 'MALE',
                    'Ž' => 'FEMALE'
                ],
                'label' => false,
                'expanded' => true,
                'multiple' => false,
                ])
            ->add('phone', TextType::class, ['label' => false])
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('registrationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }

}
