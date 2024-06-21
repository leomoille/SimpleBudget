<?php

namespace App\Form;

use App\Entity\BudgetEntry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'help'  => 'Nom de votre entrée dans le budget.',
            ])
            ->add('value', NumberType::class, [
                'label' => 'Montant',
                'help'  => 'Le montant de cette entrée.',
            ])
            ->add('notes', TextType::class, [
                'label'    => 'Notes additionnelles',
                'required' => false,
                'help'     => 'Ajoutez ici des commentaires (optionnel).',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BudgetEntry::class,
        ]);
    }
}
