<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('nbPages')
            ->add('image',FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                ])
            ->add('author', EntityType::class, [
                'class'=> Author::class,
                'choice_label' => 'firstName',
            ])
            ->add('publishedAt',DateType::Class, array(
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y')-300),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
