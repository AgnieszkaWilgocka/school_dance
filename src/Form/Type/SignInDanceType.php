<?php
//
//namespace App\Form\Type;
//
//use App\Entity\Dance;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//
//class SignInDanceType extends AbstractType
//{
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder->add(
//            'dances',
//            EntityType::class,
//            [
//                'class' => Dance::class,
//                'label_choice' => function($book): string {
//                return $book->getTtitle();
//                },
//                'label' => 'label_dance',
//                'requires' => true,
//                'placeholder' => 'label_none'
//            ]
//        );
//    }
//}