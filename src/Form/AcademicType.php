<?php

namespace App\Form;

use App\Entity\Academic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\NotBlank;

class AcademicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('diploma_title', null, [
                'constraints' => new NotBlank,
                'label' => 'Titre du diplôme',
            ])
            ->add('school', null, [
                'constraints' => new NotBlank,
                'label' => 'Nom de l\'établissement',
            ])
            ->add('startedAt', null, [
                'constraints' => [
                    new NotBlank,
                    new Date,
                ],
                'label' => 'Date de début de la formation',
            ])
            ->add('endedAt', null, [
                'constraints' => [
                    new NotBlank,
                    new Date,
                ],
                'label' => 'Date de fin de la formation',
            ])
            ->add('description', null, [
                'constraints' => [
                    new NotBlank,
                ],
                'label' => 'Description de la formation',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Academic::class,
        ]);
    }
}
