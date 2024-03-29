<?php

namespace App\Form;

use App\Entity\Ecard;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
            ->add('message', CKEditorType::class, [
                'label' => 'Votre message :',
                'purify_html' => true,
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
