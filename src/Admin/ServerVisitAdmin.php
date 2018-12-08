<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.12.8
 * Time: 22.24
 */

namespace App\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ServerVisitAdmin extends AbstractAdmin
{
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('edit');
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('id')
            ->add('ip')
            ->add('visitDate', 'doctrine_orm_date_range', ['label' => 'Prisijungimo data']);
    }

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id')
            ->addIdentifier('ip')
            ->addIdentifier('visitDate', null, ['label' => 'Prisijungimo data']);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show->add('ip')
            ->add('visitDate', null, ['label' => 'Prisijungimo data']);
    }
}
