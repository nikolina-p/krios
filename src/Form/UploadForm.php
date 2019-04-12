<?php

namespace App\Form;

use App\Entity\XRayFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadForm extends AbstractType
{
    private $xRayFileTransformer;

    public function __construct(XRayFileTransformer $xRayFileTransformer)
    {
        $this->xRayFileTransformer = $xRayFileTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('xRayFile', FileType::class,[
                'label' => 'Upload xRay',
                ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                ]);

        //$builder->get('xRayFile')->addModelTransformer($this->xRayFileTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => XRayFile::class
        ]);
    }
}
