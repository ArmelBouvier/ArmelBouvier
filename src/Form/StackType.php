<?php

namespace App\Form;

use App\Entity\Stack;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\ImageValidator;
use Symfony\Component\Validator\Constraints\NotBlank;


class StackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,  [
                'constraints' => new NotBlank,
                'label' => 'Nom de la technologie',
            ])
            ->add('image', FileType::class, [
                'data_class' => null,
                'label' => 'Choisir un logo',
            ])
            ->add('genre')
            ->add('version')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stack::class,
        ]);
    }
}
