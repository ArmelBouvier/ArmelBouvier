<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'constraints' => new NotBlank,
                'label' => 'Intitulé du poste',
            ])
            ->add('company', null, [
                'constraints' => new NotBlank,
                'label' => 'Nom de l\'entreprise',
            ])
            ->add('description', null, [
                'constraints' => new NotBlank,
                'label' => 'Description du travail effectué',
            ])
            ->add('startedAt', DateType::class, [
                'widget' => 'single_text',  
                'label' => 'Date de début du poste',
            ])
            ->add('endedAt', DateType::class, [
                'widget' => 'single_text',                
                'label' => 'Date de fin du poste',
            ])            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
