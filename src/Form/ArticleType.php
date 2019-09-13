<?php

namespace App\Form;

use App\Entity\{Article,User,Tag,Category};
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('imagePath')
            ->add('author',EntityType::class,[
                'class'=>User::class,
                'choice_label'=> 'userName'
            ])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'multiple'=>true,
                'expanded'=>true,
                'choice_label'=>'name',
            ])
            ->add('tag',EntityType::class,[
                'class'=>Tag::class,
                'multiple'=>true,
                'expanded'=>true,
                'choice_label'=>'name',
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
