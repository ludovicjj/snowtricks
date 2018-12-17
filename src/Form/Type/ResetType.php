<?php

namespace App\Form\Type;

use App\DTO\ResetDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ResetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'Nouveau mot de passe'
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmer nouveau mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ResetDTO::class,
        ]);
    }
}