<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, ['label' => 'Prénom'])
        ->add('lastname', TextType::class, ['label' => 'Nom'])
        ->add('email', EmailType::class)
        ->add('imageFile', VichFileType::class, [
            'label' => 'Choisir un avatar',
            'allow_delete' => true,
            'download_uri' => false,
            'required' => false,
            'delete_label' => 'Supprimer mon avatar'
        ]);
    }
}
