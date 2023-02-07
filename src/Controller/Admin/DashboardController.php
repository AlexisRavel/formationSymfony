<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Tags;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController {
    #[Route('/admin', name: 'admin')]
    public function index(): Response {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(PostCrudController::class)->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard {
        return Dashboard::new()
            ->setTitle('Blog');
    }

    public function configureMenuItems(): iterable {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', 'app_blog');
        yield MenuItem::linkToCrud('Publications', 'fas fa-comments', Post::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Comment::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-comments', Tags::class);
        yield MenuItem::linkToCrud('User', 'fas fa-comments', User::class);
    }
}
