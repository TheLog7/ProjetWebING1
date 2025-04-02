<?php

namespace App\Form;

use App\Entity\Imprimante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImprimanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'imprimante',
                'attr' => ['placeholder' => 'Ex: Imprimante Bureau 1']
            ])
            ->add('identifiantUnique', TextType::class, [
                'label' => 'Identifiant unique',
                'attr' => ['placeholder' => 'Ex: IMPR123456']
            ])
            ->add('modele', TextType::class, [
                'label' => 'Modèle',
                'attr' => ['placeholder' => 'Ex: HP LaserJet']
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Fonctionnel' => 'Fonctionnel',
                    'Hors service' => 'Hors service'
                ],
                'placeholder' => 'Sélectionnez un statut'
            ])
            ->add('niveauEncre', IntegerType::class, [
                'label' => 'Niveau d\'encre',
                'required' => false
            ])
            ->add('niveauBatterie', IntegerType::class, [
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
            'data_class' => Imprimante::class,
        ]);
    }
}
