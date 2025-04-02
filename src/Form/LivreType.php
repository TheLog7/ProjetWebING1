<?php
namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du livre',
            ])
            ->add('nom_auteur', TextType::class, [
                'label' => 'Nom de l’auteur',
            ])
            ->add('prenom_auteur', TextType::class, [
                'label' => 'Prénom de l’auteur',
                'required' => false, 
            ])
            ->add('date_publication', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de publication',
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Roman' => 'Roman',
                    'Science-fiction' => 'Science-fiction',
                    'Fantastique' => 'Fantastique',
                    'Policier' => 'Policier',
                    'Historique' => 'Historique',
                    'Biographie' => 'Biographie',
                    'Essai' => 'Essai',
                    'Poésie' => 'Poésie',
                ],
                'placeholder' => 'Sélectionnez un genre',
            ])
            ->add('ajouter', SubmitType::class, [
                'label' => 'Ajouter le livre',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
