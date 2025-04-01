<?php

namespace App\Form;

use App\Entity\Ordinateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class OrdinateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'ordinateur',
                'attr' => ['placeholder' => 'Ex: PC Bureau 1']
            ])
            ->add('marque', TextType::class, [
                'label' => 'Marque',
                'attr' => ['placeholder' => 'Ex: Dell, HP, Lenovo...']
            ])
            ->add('numeroSerie', TextType::class, [
                'label' => 'Numéro de série',
                'attr' => ['placeholder' => 'Ex: ABC123456']
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Disponible' => 'Disponible',
                    'En maintenance' => 'En maintenance',
                    'Hors service' => 'Hors service',
                    'Indisponible' => 'Indisponible'
                ],
                'placeholder' => 'Sélectionnez un statut'
            ])
            ->add('localisation', TextType::class, [
                'label' => 'Localisation',
                'attr' => ['placeholder' => 'Ex: Salle informatique, Bureau 2...']
            ])

            ->add('niveauBatterie', IntegerType::class, [
                'label' => 'Niveau de batterie',
                'required' => false
            ])

            ->add('date_achat', DateType::class, [
                'label' => 'Date d\'achat',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('derniere_maintenance', DateType::class, [
                'label' => 'Dernière maintenance',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('est_en_service', CheckboxType::class, [
                'label' => 'En service ?',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ordinateur::class,
        ]);
    }
}
