<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\UsuarioRepository;
use App\Entity\Usuario;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'inactiveUsersCount' => $usuarioRepository->findInactiveCount()
        ]);
    }
}
