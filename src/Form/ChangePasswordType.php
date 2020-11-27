<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('old_password', PasswordType::class, [
            'mapped' => false,
           'label' => 'Mon mot de passe actuel',
           'attr' => [
               'placeholder' => 'Saisissez votre mot de passe actuel'
           ]
       ])
        ->add('new_password', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'invalid_message' => 'le mot de passe et la confirmation doivent être identique',
            'label' => 'Mon nouveau mot de passe',
            'required' => true,
            'first_options' =>[
                'label' => 'Nouveau Mot de passe',
                'attr' => [ 'placeholder' => "Merci de saisir un nouveau mot de passe"]
                 ],
            'second_options' =>[
                'label' => 'Confirmez votre nouveau mot de passe',
                'attr' => [ 'placeholder' => "Merci de confirmer votre nouveau mot de passe"]
        ]
            
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
