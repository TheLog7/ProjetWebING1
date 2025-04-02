<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    #[Route('/article', name: 'app_article')]
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $category = $request->query->get('category');
        $dateFilter = $request->query->get('date_filter');
    
        $queryBuilder = $articleRepository->createQueryBuilder('a');
    
        if ($category) {
            $queryBuilder->andWhere('a.category = :category')
                         ->setParameter('category', $category);
        }
    
        if ($dateFilter === 'asc') {
            $queryBuilder->orderBy('a.createAt', 'ASC'); // Moins récent en premier
        } elseif ($dateFilter === 'desc') {
            $queryBuilder->orderBy('a.createAt', 'DESC'); // Plus récent en premier
        }
    
        $articles = $queryBuilder->getQuery()->getResult();
    
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    

    #[Route('/articles/ajout', name: 'app_article_ajout')]
    public function ajouter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreateAt(new \DateTimeImmutable());
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article ajouté avec succès !');

            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/articles/{id}', name: 'app_article_details', requirements: ['id' => '\d+'])]
    public function details(Article $article): Response
    {
        return $this->render('article/details.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/{id}/supprimer', name: 'app_article_supprimer')]
    public function supprimer(Article $article, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($this->getUser()->getType() === 'Administration' || $this->getUser()->getNiveau() === 3) {
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article supprimé avec succès !');
        } else {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer cet article.');
        }

        return $this->redirectToRoute('app_article');
    }
}
