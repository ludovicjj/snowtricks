<?php

namespace App\Form\Type;

use App\DTO\TrickDTO;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateTrickType extends AddTrickType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrickDTO::class
        ]);
    }
}