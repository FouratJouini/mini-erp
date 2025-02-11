<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Article;

class ArticleDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'libelle',
            ])
            ->add('quantity', NumberType::class, [
                'required' => true,
            ])
            ->add('unitPrice', NumberType::class, [
                'required' => true,
            ])
            ->add('discount', NumberType::class, [
                'required' => false,
            ])
            ->add('totalPrice', NumberType::class, [
                'required' => true,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // Adjust if needed
        ]);
    }
}
