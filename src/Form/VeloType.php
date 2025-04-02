<?php

namespace App\Form;

use App\Entity\Velo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VeloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du vélo',
                'attr' => ['placeholder' => 'Ex: Vélo 1']
            ])
            ->add('marque', TextType::class, [
                'label' => 'Marque',
                'attr' => ['placeholder' => 'Ex: Trek, Giant...']
            ])
            ->add('identifiantUnique', TextType::class, [
                'label' => 'Identifiant unique',
                'attr' => ['placeholder' => 'Ex: VELO123456']
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Disponible' => 'Disponible',
                    'En maintenance' => 'En maintenance',
                    'Hors service' => 'Hors service',
                    'Indisponible' => 'Indisponible'
                ],
                'placeholder' => 'Sélectionnez un statut'
            ])
            ->add('niveauBatterie', IntegerType::class, [
                'label' => 'Niveau de batterie',
                'required' => false
            ])
            ->add('derniereInteraction', DateType::class, [
                'label' => 'Dernière interaction',
                'widget' => 'single_text',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Velo::class,
        ]);
    }
}
