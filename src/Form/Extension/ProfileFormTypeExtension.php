<?php
namespace App\Form\Extension;
use App\Form\ContactInfoType;
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.5
 * Time: 23.09
 */
class ProfileFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('email')
            ->remove('username')
            ->remove('current_password')
            ->add('firstName', TextType::class,
                [
                    'label'         => 'profile.show.firstName',
                    'required'      => true,
                    'constraints'   => [new NotBlank(), new Length(['max' => 64])]
                ])
            ->add('lastName', TextType::class,
                [
                    'label'     => 'profile.show.lastName',
                    'required'  => false,
                    'constraints'   => [new Length(['max' => 128])]
                ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Lytis',
                'required' => false,
                'choices' => ['Vyras' => 0, 'Moteris' => 1]
            ])
            ->add('age', IntegerType::class, ['required' => false, 'label' => 'Amžius'])
            ->add('birthDate', BirthdayType::class, ['required' => false, 'label' => 'Gymimo data'])
            ->add('addresses', CollectionType::class,
                [
                    'entry_type'    => ContactInfoType::class,
                    'label'         => 'Adresai',
                    'entry_options' => ['label' => 'Pasirinkite'],
                    'required'      => false,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'prototype'     => true,
                    'attr'          => ['class' => 'address-type'],
                    'by_reference'  => false
                ]);
    }
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return ProfileFormType::class;
    }
}
