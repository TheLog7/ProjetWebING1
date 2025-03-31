<?php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Choice;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Âge',
                'constraints' => [
                    new NotBlank(['message' => 'L\'âge est obligatoire']),
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Autre' => 'Autre',
                ],
                'expanded' => true,  // Affiche des boutons radio
                'multiple' => false,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'utilisateur',
                'choices' => [
                    'Administration' => 'Administration',
                    'Enseignant' => 'Enseignant',
                    'Eleve' => 'Eleve',
                ],
                'expanded' => false, // Affiche un menu déroulant
                'multiple' => false,
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false, // Ne lie pas ce champ directement à l'entité
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, GIF)',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ]);

   
        $builder->add('classe', ChoiceType::class, [
            'label' => 'Classe (si Eleve)',
            'choices' => [
                'Aucune' => null, 
                '6eme' => '6eme',
                '5eme' => '5eme',
                '4eme' => '4eme',
                '3eme' => '3eme',
            ],
        ]);

        $builder->add('matiere', ChoiceType::class, [
            'label' => 'Matière (si Professeur)',
            'choices' => [
                'Aucune' => null, 
                'Mathématiques' => 'Mathématiques',
                'Français' => 'Français',
                'Anglais' => 'Anglais',
                'Histoire-Géographie' => 'Histoire-Géographie',
                'SVT' => 'SVT',
                'Technologie' => 'Technologie',
                'Physique-Chimie' => 'Physique-Chimie',
                'EPS' => 'EPS',
                'Arts plastiques' => 'Arts plastiques',
                'Éducation musicale' => 'Éducation musicale',
                'Aide au révision' => 'Révisions',
                'LV2'=>'LV2',
                'Conseillère d\'orientation' => 'Orientation',
            ],
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'allow_extra_fields' => true, // Permet d'ajouter des champs supplémentaires comme matière et classe
        ]);
    }
}
