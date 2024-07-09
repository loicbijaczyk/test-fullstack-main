<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClockingManyUsersType extends AbstractType
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
        
        $builder->add('user', EntityType::class, [
            'class'        => User::class,
            'choice_label' => static function(
                ?User $choice
            ) : ?string {
                return $choice === null
                    ? null
                    : $choice->getFirstName() . ' ' . $choice->getLastName();
            },
            'label'        => 'entity.Clocking.clockingUser',
        ]);

        $builder->add('duration', IntegerType::class, [
            'label' => 'entity.Clocking.duration',
            'mapped' => false
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
                'data_class' => User::class,
            ]
        );
    }
}
