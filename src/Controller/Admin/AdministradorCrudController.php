<?php

namespace App\Controller\Admin;

use App\Entity\Usuario;
use App\Entity\Administrador;
use App\Form\AdministradorType;
use App\Repository\AdministradorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/administrador')]
final class AdministradorCrudController extends AbstractController
{
    #[Route(name: 'app_administrador_index', methods: ['GET'])]
    public function index(AdministradorRepository $administradorRepository): Response
    {
        return $this->render('crud/administrador/index.html.twig', [
            'administradors' => $administradorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_administrador_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $usuario = new Usuario();
        $administrador = new Administrador();
        $form = $this->createForm(AdministradorType::class, $administrador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userEntity = $form->get('usuario');
            $plainPassword = $userEntity->get('plainPassword')->getData();

            $usuario->setEmail($userEntity->get('email')->getData());

            // encode the plain password
            $usuario->setPassword($userPasswordHasher->hashPassword($usuario, $plainPassword));

            $usuario->setEsUsuarioActivo(true);

            $usuario->setRoles(['ROLE_ADMIN']);

            $administrador->setUsuario($usuario);

            $entityManager->persist($usuario);
            $entityManager->persist($administrador);
            $entityManager->flush();

            return $this->redirectToRoute('app_administrador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/administrador/new.html.twig', [
            'administrador' => $administrador,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_administrador_show', methods: ['GET'])]
    public function show(Administrador $administrador): Response
    {
        return $this->render('administrador/show.html.twig', [
            'administrador' => $administrador,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_administrador_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Administrador $administrador, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdministradorType::class, $administrador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_administrador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/administrador/edit.html.twig', [
            'administrador' => $administrador,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_administrador_delete', methods: ['POST'])]
    public function delete(Request $request, Administrador $administrador, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administrador->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($administrador);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_administrador_index', [], Response::HTTP_SEE_OTHER);
    }
}
