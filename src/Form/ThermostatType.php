<?php

namespace App\Form;

use App\Entity\Thermostat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThermostatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du thermostat',
                'attr' => ['placeholder' => 'Ex: Thermostat Salle 1']
            ])
            ->add('identifiantUnique', TextType::class, [
                'label' => 'Identifiant unique',
                'attr' => ['placeholder' => 'Ex: THERM123456']
            ])
            ->add('temperatureActuelle', NumberType::class, [
                'label' => 'Température actuelle',
                'required' => false
            ])
            ->add('temperatureCible', NumberType::class, [
                'label' => 'Température cible',
                'required' => false
            ])
            ->add('mode', ChoiceType::class, [
                'label' => 'Mode',
                'choices' => [
                    'Chauffage' => 'Chauffage',
                    'Refroidissement' => 'Refroidissement',
                    'Automatique' => 'Automatique',
                    'Éteint' => 'Éteint'
                ],
                'placeholder' => 'Sélectionnez un mode'
            ])
            ->add('connectivite', ChoiceType::class, [
                'label' => 'Connectivité',
                'choices' => [
                    'Wi-Fi' => 'Wi-Fi',
                    'Ethernet' => 'Ethernet',
                    'Aucune' => 'Aucune'
                ],
                'placeholder' => 'Sélectionnez une connectivité'
            ])
            ->add('niveauBatterie', NumberType::class, [
                'label' => 'Niveau de batterie',
                'required' => false
            ])
            ->add('salle', TextType::class, [
                'label' => 'Salle',
                'attr' => ['placeholder' => 'Ex: Salle de réunion']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Thermostat::class,
        ]);
    }
}
