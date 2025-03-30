<?php
// src/Form/UtilisateurType.php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    ->add('nom', TextType::class, ['label' => 'Nom'])
    ->add('prenom', TextType::class, ['label' => 'Prénom'])
    ->add('email', TextType::class, ['label' => 'Email'])
    ->add('motDePasse', PasswordType::class, [
        'label' => 'Mot de passe (laisser vide si inchangé)',
        'mapped' => false,
        'required' => false,
    ])
    ->add('type', ChoiceType::class, [
        'label' => 'Type',
        'choices' => [
            'Administration' => 'Administration',
            'Enseignant' => 'Enseignant',
            'Eleve' => 'Eleve',
        ]
    ])
    ->add('sexe', ChoiceType::class, [
        'label' => 'Sexe',
        'choices' => [
            'Homme' => 'Homme',
            'Femme' => 'Femme',
            'Autre' => 'Autre',
        ]
    ])
    ->add('niveau', IntegerType::class, ['label' => 'Niveau'])
    ->add('points', IntegerType::class, ['label' => 'Points'])
    ->add('age', IntegerType::class, ['label' => 'Âge'])
    ->add('photo', FileType::class, [
        'label' => 'Photo de profil',
        'mapped' => false,
        'required' => false,
    ])
    ->add('submit', SubmitType::class, [
        'label' => 'Modifier',
        'attr' => ['class' => 'bg-blue-500 text-white px-4 py-2 rounded-lg']
    ]);
    }
}
