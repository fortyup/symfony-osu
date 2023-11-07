<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticleRepository $articlesRepository): Response
    {

        $isAdmin = false;
        if ($this->isGranted('ROLE_ADMIN')) {
            $isAdmin = true;
        }

        return $this->render('home/index.html.twig', [
            'is_admin' => $isAdmin,
            'articles' => $articlesRepository->createQueryBuilder('a')
                ->orderBy('a.id', 'DESC')
                ->setMaxResults(2)
                ->getQuery()
                ->getResult(),
        ]);
    }

}
