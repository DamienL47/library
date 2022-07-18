<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('birthDate', DateType::Class, array(
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y')-300),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ))
            ->add('deathDate',DateType::Class, array(
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y')-300),
                'months' => range(date('m'), 12),
                'days' => range(date('d'), 31),
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
