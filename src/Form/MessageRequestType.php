<?php

namespace App\Form;

use App\Entity\MessageRequest;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, ['label' => 'Pranešimas'])
            ->add('receiver', EntityType::class, [
                'class' => User::class,
                'label' => 'Gavėjas',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :manager')
                        ->orWhere('u.roles LIKE :admin')
                        ->orWhere('u.roles LIKE :sadmin')
                        ->setParameter('manager', '%"'.'ROLE_MANAGER'.'"%')
                        ->setParameter('admin', '%"'.'ROLE_ADMIN'.'"%')
                        ->setParameter('sadmin', '%"'.'ROLE_SUPER_ADMIN'.'"%')
                        ->orderBy('u.username', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MessageRequest::class,
        ]);
    }
}
