<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class PatientForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Ime'])
            ->add('surname', TextType::class, ['label' => 'Prezime'])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'M' => 'MALE',
                    'Ž' => 'FEMALE'
                ],
                'label' => 'Pol',
                'expanded' => true,
                'multiple' => false,
                'data' => 'MALE',
                ])
        ->add('phone', TextType::class, ['label' => 'Telefon'])
        ->add('email', EmailType::class, ['label' => 'e-mail']);
    }

}