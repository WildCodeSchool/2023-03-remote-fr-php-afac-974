<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Painting;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PaintingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('date', DateType::class, [
        'widget' => 'single_text',
            ])
            ->add('anecdote')
            ->add('height')
            ->add('width')
            ->add('imageFile', VichFileType::class, [
                "required" => false,
            ])
            ->add("createdAt", DateTimeType::class, [
                "data" => new DateTime("now"),
            ])
            ->add('category', EntityType::class, [
                "class" => Category::class,
                "choice_label" => "name",

            ])
            ->add('artist', EntityType::class, [
                "class" => Artist::class,
                "choice_label" => "name",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Painting::class,
        ]);
    }
}
