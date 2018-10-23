<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('age')
            ->add('gender')
            ->add('birthDate')
            ->add('isIndividual')
            ->add('salary')
            ->add('position')
            ->add('additionalCompensation')
            ->add('isBlocked')
            ->add('workSinceDate')
            ->add('roles', ChoiceType::class,
                ['choices'  =>
                    [
                        'Klientas' => 'Klientas',
                        'Vadybininkas' => 'Vadybininkas',
                        'Administratorius' => 'Administratorius',
                        'Super Administratorius' => 'Super Administratorius'
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
