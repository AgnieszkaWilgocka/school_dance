<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'nick',
            TextType::class,
            [
                'label' => 'label.nick',
                'required' => true,
                'attr' => ['max_length' => 64]
            ]
        );
    }
}