<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): Response
    {
        for($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitle("Titre de l'article n°$i")
                ->setContent("Contenu de l'article n°$i")
                ->setImage("https://via.placeholder.com/350x150")
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($article);
        }

        $manager->flush();

        return new Response('Saved new product with id '.$article->getId());
    }
}
