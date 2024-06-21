<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => new NotBlank([
                    'message' => 'Vous devez saisir votre adresse email.',
                ]),
                'attr' => [
                    'class' => 'w-full py-2 px-3 border rounded',
                ],
                'label_attr' => [
                    'class' => 'block text-sm font-bold mb-2',
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label'  => 'Mot de passe',
                'mapped' => false,
                'attr'   => [
                    'autocomplete' => 'new-password',
                    'class'        => 'w-full py-2 px-3 border rounded',
                ],
                'label_attr' => [
                    'class' => 'block text-sm font-bold mb-2',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez saisir un mot de passe.',
                    ]),
                    new Length([
                        'min'        => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label'       => 'J\'accepte les conditions.',
                'mapped'      => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
