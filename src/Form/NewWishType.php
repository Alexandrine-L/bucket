<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewWishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Votre rêve :',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Ajouter une description :',
                'required' => false,
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur :',
            ])
            ->add('category', EntityType::class, [
                'label' => 'Ajouter une catégorie :',
                'class' => Category::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
