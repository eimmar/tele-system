<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.12.9
 * Time: 00.04
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class UserVisitsAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_app_user-visits';

    protected $baseRoutePattern = '/app/user-visits';

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
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
            ->add('lastLogin', 'doctrine_orm_date_range', ['label' => 'Paskutinio prisijungimo laikas']);
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
            ->addIdentifier('lastLogin', null, ['label' => 'Paskutinio prisijungimo laikas']);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('id')
            ->add('email', null, ['label' => 'El. paštas'])
            ->add('firstName', null, ['label' => 'Vardas'])
            ->add('lastName', null, ['label' => 'Pavardė'])
            ->add('lastLogin', null, ['label' => 'Paskutinio prisijungimo laikas']);
    }
}