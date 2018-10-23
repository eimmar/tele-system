<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('passwordHash')
            ->add('age')
            ->add('gender')
            ->add('confirmationToken')
            ->add('birthDate')
            ->add('isIndividual')
            ->add('salary')
            ->add('position')
            ->add('workSinceDate')
            ->add('additionalCompensation')
            ->add('isBlocked')
            ->add('roles')
            ->add('dateCreated')
            ->add('dateUpdated')
            ->add('lastVisitDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
