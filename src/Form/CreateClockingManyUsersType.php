<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Entity\Project;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class CreateClockingManyUsersType extends
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
       
        $builder->add('project', ChoiceType::class, [
            'choices'       => $options['projects'],
            'choice_label' => function (?Project $project): string {
        return $project ? $project->getName() : '';
    },
            'label'         => 'entity.Project.name',
            'mapped'        => false
        ]);

        $builder->add('date', DateType::class, [
            'label' => 'entity.Clocking.date',
            'mapped' => false
        ]);

        $builder->add('clockingUser', CollectionType::class, [
            'entry_type'    => ClockingManyUsersType::class,
            'prototype'     => true,
            'entry_options' => ['label' => false],
            'by_reference'  => false,
            'allow_add'     => true,
            'allow_delete'  => true,

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
                'data_class'    => Clocking::class,
                'projects'      => null
            ]
        );
    }
}
