<?php
namespace App\Admin;

use App\Entity\User;
use App\Form\ContactInfoType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.21
 * Time: 20.13
 */

class UserAdmin extends AbstractAdmin
{
    /**
     * @return array
     */
    private function getRoles()
    {
        return [
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_MANAGER' => 'ROLE_MANAGER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
        ];
    }

    /**
     * @return string
     */
    public function getRolesAsString()
    {
        $roles = array();
        foreach ($this->getRoles() as $role) {
            $role = explode('_', $role);
            array_shift($role);
            $roles[] = ucfirst(strtolower(implode(' ', $role)));
        }

        return implode(', ', $roles);
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('email', TextType::class, ['constraints' => new Email()])
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class, ['required' => false])
            ->add('enabled', CheckboxType::class, ['required' => false]);

//        if ($this->isCurrentUserSuperAdmin()) {
            $form->add('roles', ChoiceType::class,
                [
                    'choices' => $this->getRoles(),
                    'multiple' => true,
                ]
            );
//        }

        $form->add('addresses', CollectionType::class,
            [
                'entry_type'    => ContactInfoType::class,
                'label'         => 'Adresai',
                'entry_options' => ['label' => 'profile.show.address'],
                'required'      => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'prototype'     => true,
                'attr'          => ['class' => 'address-type'],
                'by_reference' => false
            ]);

        if ($this->getRequest()->get('_route') === 'admin_app_user_create') {
            $form->add('plainPassword', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'options' => ['translation_domain' => 'FOSUserBundle'],
                    'invalid_message' => 'fos_user.password.mismatch',
                    'required' => true,
                    'first_options'  => ['label' => 'form.password'],
                    'second_options' => ['label' => 'form.password_confirmation'],
                ]
            );
        }
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('id')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('roles')
            ->add('enabled');
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('email')
            ->addIdentifier('firstName')
            ->addIdentifier('lastName')
            ->addIdentifier('roles', null, ['template' => 'admin/role_list.html.twig'])
            ->addIdentifier('enabled');
    }

    /**
     * @param ErrorElement $errorElement
     * @param $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $other = $this->modelManager->findOneBy($this->getClass(), ['email' => $object->getEmail()]);

        if (null !== $other && $other->getId() !== $object->getId()) {
            $errorElement
                ->with('email')
                ->addViolation('fos_user.email.already_used')
                ->end();
        }
    }

    /**
     * @return bool
     */
    private function isCurrentUserSuperAdmin()
    {
        /** @var User $user */
        $user = $this->getConfigurationPool()
            ->getContainer()
            ->get('security.token_storage')
            ->getToken()
            ->getUser();

        return $user->isSuperAdmin();
    }
}
