<?php

namespace App\Controller;

use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;

class IndexController extends AbstractController
{
    public function __construct(
        private Security $security,
    ) {}

    #[Route('/', name: 'app_index')]
    public function index(LibroRepository $libroRepository): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }

        if ($this->security->isGranted('ROLE_USER')) {
            return $this->render('index/feed.html.twig' , [
                'libros' => $libroRepository->findAny(10)
            ]);
        }

        return $this->render('index/index.html.twig');
    }
}
