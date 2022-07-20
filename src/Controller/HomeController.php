<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, PaginatorInterface$paginator, Request $request): Response
    {
        $posts = $paginator->paginate(
            $postRepository->findAllDesc(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('home/index.html.twig', [
            'title' => 'Accueil',
            'posts' => $posts
        ]);
    }
}
