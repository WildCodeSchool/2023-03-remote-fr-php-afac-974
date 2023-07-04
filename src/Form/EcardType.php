<?php

namespace App\Form;

use App\Entity\Ecard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EcardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sentTo', TextType::class, [
                'label' => 'Destinataire :',
                'attr' => [
                    'placeholder' => 'Tapez ici l\'adresse mail du destinataire'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message :',
                'attr' => [
                'rows' => 12,
                    'placeholder' => 'Veuillez taper votre message ici'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ecard::class,
        ]);
    }
}
