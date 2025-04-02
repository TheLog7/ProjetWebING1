<?php 
namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Titre de l\'article']
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => ['placeholder' => 'Écris ton article ici...']
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'Actualités' => 'Actualités',
                    'Événements' => 'Événements',
                    'Conseils Éducatifs' => 'Conseils Éducatifs',
                    'Vie Scolaire' => 'Vie Scolaire',
                ],
                'placeholder' => 'Sélectionner une catégorie',
            ])
            ->add('image', TextType::class, [
                'label' => 'Image URL',
                'required' => false,
                'attr' => ['placeholder' => 'URL de l\'image']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
