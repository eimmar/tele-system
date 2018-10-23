<?php

namespace App\Form;

use App\Entity\ServiceRestriction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceRestrictionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateCreated')
            ->add('comment')
            ->add('speedLimitMb')
            ->add('dateModified')
            ->add('service')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ServiceRestriction::class,
        ]);
    }
}
