<?php

namespace App\Controller\Crud;

use App\Form\CopiaLibroType;
use App\Entity\Libro;
use App\Entity\CopiaLibro;
use App\Form\LibroType;
use App\Repository\LibroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/libros')]
final class LibroCrudController extends AbstractController
{
    #[Route(name: 'app_libro_index', methods: ['GET'])]
    public function index(LibroRepository $libroRepository): Response
    {
        return $this->render('crud/libro/index.html.twig', [
            'libros' => $libroRepository->findAll(),
        ]);
    }

    #[Route('/admin/crear', name: 'app_libro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $libro = new Libro();

        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($libro);
            $entityManager->flush();

            $siguienteAccion = $form->get('guardarCrearOtro')->isClicked()
                ? 'app_libro_new'
                : 'app_libro_index';

            return $this->redirectToRoute($siguienteAccion);
        }

        return $this->render('crud/libro/new.html.twig', [
            'libro' => $libro,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_libro_show', methods: ['GET'])]
    public function show(Libro $libro): Response
    {
        return $this->render('crud/libro/show.html.twig', [
            'libro' => $libro,
        ]);
    }

    #[Route('/{id}/admin/edit', name: 'app_libro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Libro $libro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LibroType::class, $libro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/libro/edit.html.twig', [
            'libro' => $libro,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}/borrar', name: 'app_libro_delete', methods: ['POST'])]
    public function delete(Request $request, Libro $libro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $libro->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($libro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_libro_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/{id}/copias', name: 'app_copia_libro_crud_index', methods: ['GET', 'POST'])]
    public function indexCopies(Request $request, Libro $libro, EntityManagerInterface $entityManager): Response
    {
        $copiaLibro = new CopiaLibro();
        $form = $this->createForm(CopiaLibroType::class, $copiaLibro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $copiaLibro->setLibro($libro);

            $requiereMultiplesCopias = $form->get('guardar_multiple')->getData();
            if ($requiereMultiplesCopias) {
                $copiasAGuardar = $form->get('numero_copias')->getData();

                for ($i = 0; $i < $copiasAGuardar; $i++) {
                    $newCopiaLibro = clone $copiaLibro;
                    $entityManager->persist($newCopiaLibro);
                    $entityManager->flush();
                }
            }

            $entityManager->persist($copiaLibro);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_copia_libro_crud_index',
                ['id' => $libro->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('crud/copia_libro/index.html.twig', [
            'libro' => $libro,
            'copia_libro' => $copiaLibro,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}/copias/{copy_id}/edit', name: 'app_copia_libro_crud_edit', methods: ['GET', 'POST'])]
    public function editCopy(
        #[MapEntity(mapping: ['id' => 'id'])]
        Libro $libro,
        #[MapEntity(mapping: ['copy_id' => 'id'])]
        CopiaLibro $copiaLibro,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CopiaLibroType::class, $copiaLibro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_copia_libro_crud_index',
                ['id' => $libro->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('crud/copia_libro/edit.html.twig', [
            'libro' => $libro,
            'copia_libro' => $copiaLibro,
            'form' => $form,
        ]);
    }

    #[Route('/admin/{id}/copias/{copy_id}', name: 'app_copia_libro_crud_delete', methods: ['POST'])]
    public function deleteCopy(
        #[MapEntity(mapping: ['id' => 'id'])]
        Libro $libro,
        #[MapEntity(mapping: ['copy_id' => 'id'])]
        CopiaLibro $copiaLibro,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $copiaLibro->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($copiaLibro);
            $entityManager->flush();
        }

        return $this->redirectToRoute(
            'app_copia_libro_crud_index',
            ['id' => $libro->getId()],
            Response::HTTP_SEE_OTHER
        );
    }
}
