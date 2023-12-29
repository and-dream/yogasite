<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, 
             options: [
                'label' => 'Nom'
                
                
            ])
            ->add('prenom', TextType::class, options: [
                'label' => 'Prénom'

            ])
            ->add('email', EmailType::class, options: [
                'label' => 'Email'

            ])
            ->add('telephone', TextType::class, options: [
                'label' => 'Téléphone'

            ])
            ->add('message', TextType::class, options: [
                'label' => 'Votre message'

            ])

            ->add('valider', SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
