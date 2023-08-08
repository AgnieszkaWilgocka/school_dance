<?php

namespace App\Form\Type;

use App\Entity\Tag;
use App\Form\DataTransformer\TagsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use \Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Dance;
class DanceType extends AbstractType
{
    private TagsDataTransformer $tagsDataTransformer;

    public function __construct(TagsDataTransformer $tagsDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label.name',
                'required' => true,
                'attr' => ['max_length' => 64],
                ]);
        $builder->add(
            'field',
            ChoiceType::class,
            [
                'label' => 'label.field',
                'required' => true,
                'choices' => range(2,21),
            ]
        );

        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label_tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );

        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Dance::class]);
    }

    public function getBlockPrefix(): string
    {
        return 'dance';
    }
}