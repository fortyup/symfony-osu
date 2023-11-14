<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Contact;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $entityManager; // Declare the EntityManager

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager; // Inject the EntityManager
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $usersCount = $this->entityManager->getRepository(Users::class)->count([]);
        $articlesCount = $this->entityManager->getRepository(Article::class)->count([]);
        $contactsCount = $this->entityManager->getRepository(Contact::class)->count([]);

        return $this->render('admin/dashboard.html.twig', [
            'usersCount' => $usersCount,
            'articlesCount' => $articlesCount,
            'contactsCount' => $contactsCount,
        ]);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToUrl('Back to website', 'fa-solid fa-clock-rotate-left', '/'),
            MenuItem::section('Dashboard'),
            MenuItem::linkToCrud('Users', 'fa-solid fa-user', Users::class),
            MenuItem::linkToCrud('Articles', 'fa-solid fa-newspaper', Article::class),
            MenuItem::linkToCrud('Contacts', 'fa-solid fa-envelope', Contact::class),
        ];
    }
}
