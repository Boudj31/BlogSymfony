<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Nom',
                'attr' => [
                'placeholder' => "Merci de saisir votre nom",
              //  'class' => 'form-control'
            ]
        ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom',
                'attr' => [
                'placeholder' => "Merci de saisir votre nom",
              //  'class' => 'form-control'
            ]
        ])
            ->add('email', EmailType::class,[
                'label' => 'email',
                'attr' => [
                'placeholder' => "Merci de saisir votre email",
              //  'class' => 'form-control'
            ]
        ])
            ->add('phone', IntegerType::class,[
                'label' => 'Mobile',
                'attr' => [
                'placeholder' => "Merci de saisir votre numéro de téléphone",
               // 'class' => 'form-control'
            ]
        ])
            ->add('birthday', DateIntervalType::class,[
                'label' => 'Date de naissance',
                'attr' => [
                'placeholder' => "Merci de saisir votre Date de naissance ",
               // 'class' => 'form-control'
            ]
        ])
       
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
