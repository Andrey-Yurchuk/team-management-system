<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        {
            $builder
                ->add('name', TextType::class)
                ->add('client', TextType::class)
                ->add('startDate', DateType::class, [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ])
                ->add('endDate', DateType::class, [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'required' => false,
                ])
                ->add('isActive', ChoiceType::class, [
                    'choices' => [
                        'Yes' => true,
                        'No' => false,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'data' => true,
                ]);
        }
    }
}