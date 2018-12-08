<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.6
 * Time: 21.55
 */
namespace App\Form\Extension;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
class RegistrationFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->remove('username');
        $builder->add(
            'firstName',
            TextType::class,
            [
                'label' => 'Vardas',
                'required' => true,
                'constraints' => [new NotBlank()]
            ]
        )->add(
            'lastName',
            TextType::class,
            [
                'label' => 'Pavardė',
                'required' => false,
            ]
        );
    }
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return RegistrationFormType::class;
    }
}
