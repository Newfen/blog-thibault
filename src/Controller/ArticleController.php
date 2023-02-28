<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepo, CategoryRepository $categoryRepo): Response
    {
        $articles = $articleRepo->findAll();

        $categories = $categoryRepo->findUsedCategories();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'usedCategories' => $categories,
        ]);
    }

    #[Route('/article/show/{slug}', name: 'app_article_show')]
    public function show(Article $article, Request $request, EntityManagerInterface $em): Response
    {
        if (!$article) throw $this->createNotFoundException('Cet Article n\'est exist plus!');

        // On crée un commentaire
        $comment = new Comment;
        // Géneration du formulaire
        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $comment->setCreatedAt(new DateTime());
            $comment->setIsActive(1);


            $em->persist($comment);
            $em->flush();

            // dd($commentaire);

            return $this->redirectToRoute('app_article_show', [
                'article' => $article,
                'slug' => $article->getSlug(),
                'id' => $article->getId()
            ]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'formComment' => $formComment->createView(),
        ]);
    }





}
