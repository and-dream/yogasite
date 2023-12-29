<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', options: [
                'label' => 'Email'
            ])
            // ->add('roles')
            ->add('password', options: [
                'label' => 'Mot de passe'
            ])
            ->add('lastname', options: [
                'label' => 'Nom'
            ])
            ->add('firstname', options: [
                'label' => 'Prénom'
            ])
            ->add('phone', options: [
                'label' => 'Téléphone'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
