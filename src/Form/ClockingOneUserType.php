<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClockingOneUserType extends AbstractType
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
        
        $builder->add('project', EntityType::class, [
            'class'        => Project::class,
            'label'        => 'entity.Clocking.clockingProject',
        ]);

        $builder->add('duration', IntegerType::class, [
            'label' => 'entity.Clocking.duration',
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
                'data_class' => ClockingProject::class,
            ]
        );
    }
}
