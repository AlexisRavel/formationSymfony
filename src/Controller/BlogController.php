<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController {
    #[Route('/', name: 'app_blog', defaults: ['page'=>'1'], methods: ['GET'])]
    #[Route('/page/{page<[1-9]\d{0,8}>}', name: 'app_blog_page', methods: ['GET'])]

    public function index(int $page): Response {        
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController : page'.$page,
        ]);
    }
}
