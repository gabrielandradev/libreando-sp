<?php

namespace App\Controller\Crud;

use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/usuarios')]
final class UsuarioCrudController extends AbstractController
{
    #[Route( name: 'app_usuario_index', methods: ['GET'])]
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('crud/usuario/index.html.twig', [
            'usuarios' => $usuarioRepository->findAll(),
        ]);
    }

    #[Route('/crear/estudiante', name: 'app_estudiante_nuevo', methods: ['GET', 'POST'])]
    public function crearEstudiante(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_NOT_AUTHENTICATED');

        return $this->redirectToRoute('app_registro_estudiantes');
    }

    #[Route('/crear/profesor', name: 'app_profesor_nuevo', methods: ['GET', 'POST'])]
    public function crearProfesor(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_NOT_AUTHENTICATED');

        return $this->redirectToRoute('app_registro_profesores');
    }

    #[Route('/{id}', name: 'app_usuario_show', methods: ['GET'])]
    public function show(Usuario $usuario): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('usuario/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_usuario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(RegistrationFormType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_usuario_delete', methods: ['POST'])]
    public function delete(Request $request, Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
    }

    //Hay un error que hace que si borro el "/admin" de la fuente, no se puede acceder
    //"App\Entity\Usuario" object not found by "Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver".
    #[Route('/admin/pendientes', name: 'app_usuarios_pendientes', methods: ['GET'])]
    public function pending(Request $request, EntityManagerInterface $entityManager): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $usuarios_pendientes = $entityManager->getRepository(Usuario::class)->findInactive();

        return $this->render("crud/usuario/pending.html.twig", [
            "usuarios" => $usuarios_pendientes
        ]);
    }

    #[Route('/admin/usuario/{id}/aceptar', name: 'app_usuario_aceptar', methods: ['POST'])]
    public function acceptUser(Request $request, Usuario $usuario, EntityManagerInterface $entityManager)
    {
        if ($this->isCsrfTokenValid('activate'.$usuario->getId(), $request->getPayload()->getString('_token'))) {
            $usuario->setEsUsuarioActivo(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_usuarios_pendientes', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/usuario/{id}/rechazar', name: 'app_usuario_rechazar', methods: ['POST'])]
    public function rejectUser(Request $request, Usuario $usuario, EntityManagerInterface $entityManager)
    {
        if ($this->isCsrfTokenValid('reject'.$usuario->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_usuarios_pendientes', [], Response::HTTP_SEE_OTHER);
    }
}
