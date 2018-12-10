<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\ContactInfo;
use App\Repository\CityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('houseNumber', TextType::class,
                [
                    'label' => 'Namo numeris',
                    'constraints'   => [new Length(['max' => 64])]

                ])
            ->add('street', TextType::class,
                [
                    'label' => 'Gatvė',
                    'required'      => true,
                    'constraints'   => [new NotBlank(), new Length(['max' => 255])]
                ])
            ->add('postalCode', TextType::class,
                [
                    'label' => 'Pašto kodas',
                    'required'      => true,
                    'constraints'   => [new NotBlank(), new Length(['max' => 64])]
                ])
            ->add('phoneNumber', TextType::class,
                [
                    'label' => 'Telefono numeris',
                    'required'      => true,
                    'constraints'   => [new NotBlank(), new Length(['max' => 64])]
                ])
            ->add('city', EntityType::class,
                [
                    'class' => City::class,
                    'label' => 'Miestas',
                    'empty_data' => 'address.please_select',
                    'query_builder' => function (CityRepository $er) {
                        return $er->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                    }
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactInfo::class,
        ]);
    }
}
