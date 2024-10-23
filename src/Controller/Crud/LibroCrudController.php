<?php

namespace App\Controller\Crud;

use App\Entity\Autor;
use App\Entity\Libro;
use App\Entity\CopiaLibro;
use App\Entity\DisponibilidadCopiaLibro;
use App\Form\LibroType;
use App\Repository\LibroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/libro')]
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
            $numeroCopias = $form->get('numero_copias')->getData();

            for ($i = 0; $i < $numeroCopias; $i++) { 
                $copiaLibro = new CopiaLibro();

                $copiaLibro->setLibro($libro);

                $disponibilidadCopias = $form->get('disponibilidad_copias')->getData();
                $ubicacionFisica = $form->get('ubicacion_fisica_copias')->getData();

                $copiaLibro->setDisponibilidad($disponibilidadCopias);
                $copiaLibro->setUbicacionFisica($ubicacionFisica);
                
                $entityManager->persist($copiaLibro);
            }

            $entityManager->persist($libro);
            $entityManager->flush();

            return $this->redirectToRoute('app_libro_index', [], Response::HTTP_SEE_OTHER);
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
            $numeroCopias = $form->get('numero_copias')->getData();

            for ($i = 0; $i < $numeroCopias; $i++) { 
                $copiaLibro = new CopiaLibro();

                $copiaLibro->setLibro($libro);

                $disponibilidadCopias = $form->get('disponibilidad_copias')->getData();
                $ubicacionFisica = $form->get('ubicacion_fisica_copias')->getData();

                $copiaLibro->setDisponibilidad($disponibilidadCopias);
                $copiaLibro->setUbicacionFisica($ubicacionFisica);
                
                $entityManager->persist($copiaLibro);
            }

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
        if ($this->isCsrfTokenValid('delete'.$libro->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($libro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_libro_index', [], Response::HTTP_SEE_OTHER);
    }
}
