<?php

namespace App\Form\Type;

use App\DTO\RegistrationDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Pseudo'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmer mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegistrationDTO::class,
        ]);
    }
}