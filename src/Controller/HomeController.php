<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
//        $entityManager = $this->getDoctrine()->getManager();

//        $query = $entityManager->getRepository(Article::class)->createQueryBuilder('a')->getQuery();
        $lastArticles = $articleRepository->findLastTenArticles();

        $pagination = $paginator->paginate(
            $lastArticles,
            $request->query->getInt('page', 1), // le numéro de page par défaut
            5 // le nombre d'articles par page
        );

        return $this->render('home/index.html.twig', [
            'lastArticles' => $pagination,
        ]);
    }
}
