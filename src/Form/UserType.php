<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                                                    'choices' => array_flip([
                                                                                'ROLE_ADMIN' => "Administrateur",
                                                                                'ROLE_USER'  => "Utilisateur",
                                                                            ]
                                                    ),
                                                    // 'multiple' => true,
                                                    'mapped'  => false,
            ])
            // ->add('password')
            ->add('username')
            ->add('status', choiceType::class, [
                                                    'choices' => array_flip([
                                                                                '1' => 'Activé',
                                                                                '0' => 'Désactivé',
                                                    ])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
