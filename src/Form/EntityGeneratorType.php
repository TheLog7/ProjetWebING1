<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityGeneratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'entité',
                'attr' => ['placeholder' => 'Ex: Livre, Ordinateur, Utilisateur']
            ])
            ->add('attributs', TextType::class, [
                'label' => 'Attributs (nom:type, séparés par des virgules)',
                'attr' => ['placeholder' => 'Ex: nom:string, age:integer, date:datetime']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer l\'entité'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
