<?php

namespace App\Form;

use App\Entity\Creation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client')
            ->add('title')
            ->add('theme')
            ->add('description',TextareaType::class)
            ->add('category')
            ->add('link')
            ->add('color')
            ->add('is_enabled')
            ->add('endDate')
            ->add('image',FileType::class,[
                'label'=>'avatar ( jpg or png )  ',
                'multiple'=>false,
                'mapped'=>false,
                'required'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Creation::class,
        ]);
    }
}
