<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateClockingOneUserType extends
    AbstractType
{

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     *
     * @return void
     */
    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ) : void {
       
        $builder->add('clockingUser', EntityType::class, [
            'class'        => User::class,
            'choice_label' => static function(
                ?User $choice
            ) : ?string {
                return $choice === null
                    ? null
                    : $choice->getLastName() . ' ' . $choice->getFirstName();
            },
            'label'        => 'entity.Clocking.clockingUser',
        ]);

        $builder->add('date', DateType::class, [
            'label' => 'entity.Clocking.date',
        ]);
        
        $builder->add('clockingProject', CollectionType::class, [
            'entry_type'    => ClockingOneUserType::class,
            'prototype'     => true,
            'entry_options' => ['label' => false],
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,

        ]);

        $builder->add('submit', SubmitType::class, [
            'label' => 'Créer',
        ]);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults(
            [
                'data_class' => Clocking::class,
            ]
        );
    }
}
