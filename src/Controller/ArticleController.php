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

    #[Route('/article/new', name: 'app_article_new')]
    public function new(ManagerRegistry $managerRegistry, ValidatorInterface $validator): Response
    {
        $article = new Article();
        $article->setTitle('My first article');
        $article->setContent('This is the content of my first article');
        $article->setCreatedAt(new DateTimeImmutable());

        $errors = $validator->validate($article);

        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $managerRegistry->getManager()->persist($article);
        $managerRegistry->getManager()->flush();

        return new Response('Saved new article with id '.$article->getId());
    }
}
