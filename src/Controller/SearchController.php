<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Libro;

use Meilisearch\Bundle\SearchService;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(EntityManagerInterface $entityManager, SearchService $searchService, Request $request): Response
    {
        $searchQuery = $request->query->get('q') ?? '';

        $hits = $searchService->search($entityManager, Libro::class, $searchQuery); 

        return $this->render(
            'search/index.html.twig',
            [
                'libros' => $hits,
                'q' => $searchQuery,
            ]
        );
    }
}
