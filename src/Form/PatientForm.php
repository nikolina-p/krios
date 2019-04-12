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
                ])
            ->add('phone', TextType::class, ['label' => 'Telefon'])
            ->add('email', EmailType::class, ['label' => 'e-mail'])
            ->add('registrationDate', DateType::class, [
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }

}
