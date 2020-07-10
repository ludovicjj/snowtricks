<?php

namespace App\Form\Type;

use App\DTO\VideoDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add('url', TextType::class, [
            'attr' => [
                'placeholder' => 'Lien Youtube ou  DailyMotion.'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VideoDTO::class,
        ]);
    }
}