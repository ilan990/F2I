<?php
// src/Form/ContactType.php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', null, [
                'constraints' => [
                    new NotBlank(['message' => "Le champ 'Sujet' ne peut pas être vide."]),
                ],
            ])
            ->add('email', null, [
                'constraints' => [
                    new NotBlank(['message' => "Le champ 'E-mail' ne peut pas être vide."]),
                    new Email(['message' => "L'adresse e-mail '{{ value }}' n'est pas une adresse e-mail valide."]),
                ],
            ])
            ->add('message', null, [
                'constraints' => [
                    new NotBlank(['message' => "Le champ 'Message' ne peut pas être vide."]),
                    new Length([
                        'min' => 10,
                        'max' => 1000,
                        'minMessage' => "Le message doit comporter au moins {{ limit }} caractères.",
                        'maxMessage' => "Le message ne peut pas dépasser {{ limit }} caractères.",
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
