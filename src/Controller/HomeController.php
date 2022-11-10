<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(): Response
    {

        $isAdmin = false;
        if ($this->isGranted('ROLE_ADMIN')) {
            $isAdmin = true;
        }

        return $this->render('home/index.html.twig', [
            'is_admin' => $isAdmin,
        ]);
    }

}
