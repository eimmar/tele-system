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
     * @var User
     */
    private $currentUser;

    /**
     * @return array
     */
    private function getRoles()
    {
        $roles = [
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_MANAGER' => 'ROLE_MANAGER'
        ];

        if ($this->hasRole('ROLE_SUPER_ADMIN')) {
            $roles['ROLE_ADMIN'] = 'ROLE_ADMIN';
            $roles['ROLE_SUPER_ADMIN'] = 'ROLE_SUPER_ADMIN';
        }

        return $roles;
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
        $form->add('email', TextType::class, ['constraints' => new Email(), 'label' => 'El. Paštas'])
            ->add('firstName', TextType::class, ['label' => 'Vardas'])
            ->add('lastName', TextType::class, ['required' => false, 'label' => 'Pavardė']);

        if ($this->canBlock()) {
            $form->add('isBlocked', CheckboxType::class, ['required' => false, 'label' => 'Užblokuotas'])
                ->add('enabled', CheckboxType::class, ['required' => false, 'label' => 'Aktyvus']);
        }

        if ($this->canChangeRoles()) {
            $form->add('roles', ChoiceType::class,
                [
                    'choices' => $this->getRoles(),
                    'multiple' => true,
                    'label' => 'Prieigos teisės'
                ]
            );
        }

        $form->add('addresses', CollectionType::class,
            [
                'entry_type'    => ContactInfoType::class,
                'label'         => 'Adresai',
                'entry_options' => ['label' => 'Adresai'],
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
                    'invalid_message' => 'Slaptažodžiai nesutampa',
                    'required' => true,
                    'first_options'  => ['label' => 'Slaptažodis'],
                    'second_options' => ['label' => 'Pakartoti slaptažodį'],
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
            ->add('email', null, ['label' => 'El. paštas'])
            ->add('firstName', null, ['label' => 'Vardas'])
            ->add('lastName', null, ['label' => 'Pavardė'])
            ->add('roles', null, ['label' => 'Prieigos teisės'])
            ->add('enabled', null, ['label' => 'Aktyvus'])
            ->add('isBlocked', null, ['label' => 'Užblokuotas']);
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('email', null, ['label' => 'El. paštas'])
            ->addIdentifier('firstName', null, ['label' => 'Vardas'])
            ->addIdentifier('lastName', null, ['label' => 'Pavardė'])
            ->addIdentifier('roles', null, ['templat/admin/app/user/2/edite' => 'admin/role_list.html.twig', 'label' => 'Prieigos teisės'])
            ->addIdentifier('enabled', null, ['label' => 'Aktyvus'])
            ->addIdentifier('isBlocked', null, ['label' => 'Užblokuotas']);
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
     * @param string $role
     * @return bool
     */
    private function hasRole($role)
    {
        if (!$this->currentUser) {
            /** @var User $user */
            $this->currentUser = $this->getConfigurationPool()
                ->getContainer()
                ->get('security.token_storage')
                ->getToken()
                ->getUser();
        }
        return $this->currentUser->hasRole($role);
    }

    /**
     * @return bool
     */
    private function canChangeRoles()
    {
        return $this->hasRole('ROLE_SUPER_ADMIN')
        || (($this->hasRole('ROLE_MANAGER') || $this->hasRole('ROLE_ADMIN'))
                && (!$this->getSubject()->hasRole('ROLE_ADMIN')) && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN'));

    }

    /**
     * @return bool
     */
    private function canBlock()
    {
        $managerToAdmin = $this->hasRole('ROLE_MANAGER') &&
            (!$this->getSubject()->hasRole('ROLE_ADMIN') && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN'));
        $adminToSuperAdmin = $this->hasRole('ROLE_ADMIN') && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN');

        return $managerToAdmin || $adminToSuperAdmin || $this->hasRole('ROLE_SUPER_ADMIN');
    }
}
