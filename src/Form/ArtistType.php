<?php

namespace App\Form;

use App\Entity\Artist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, ['label' => 'Nom'])
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text', 'label' => 'Date de Naissance'
            ])
            ->add('nationality', TextType::class, ['label' => 'Nationalité'])
            ->add('biography', TextType::class, ['label' => 'Biographie'])
            ->add('imageFile', VichFileType::class, [
                'required' => false, 'label' => 'Fichier image'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
