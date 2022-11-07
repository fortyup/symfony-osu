<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function show(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        if (!$articles) {
            throw $this->createNotFoundException('No article found for id ');
        }

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles'=> $articles
        ]);

        //or render a template
        //in the template, print things with {{ article.title }}
        //return $this->render('article/show.html.twig', ['article' => $article]);
    }

}
