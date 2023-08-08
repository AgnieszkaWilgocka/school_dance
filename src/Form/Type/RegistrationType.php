<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => 'label.email',
                'attr' => ['max_length' => 64],
                'required' => true,
            ]
        );

        $builder->add(
            'password',
            RepeatedType::class,
            [
                'type' => PasswordType::class,
                'required' => true,
                'invalid_message' => 'the password fields must match',
                'first_options' => ['label' => 'label_password'],
                'second_options' => ['label' => 'label_password_repeat']
            ]
        );
    }
}
