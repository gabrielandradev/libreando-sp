<?php

namespace App\Controller\Crud;

use App\Entity\Descriptor;
use App\Form\DescriptorType;
use App\Repository\DescriptorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/descriptor')]
final class DescriptorCrudController extends AbstractController
{
    #[Route(name: 'app_descriptor_crud_index', methods: ['GET'])]
    public function index(DescriptorRepository $descriptorRepository): Response
    {
        return $this->render('descriptor_crud/index.html.twig', [
            'descriptors' => $descriptorRepository->findAll(),
        ]);
    }

    #[Route('/admin/crear', name: 'app_descriptor_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $descriptor = new Descriptor();
        $form = $this->createForm(DescriptorType::class, $descriptor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($descriptor);
            $entityManager->flush();

            return $this->redirectToRoute('app_descriptor_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('descriptor_crud/new.html.twig', [
            'descriptor' => $descriptor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_descriptor_crud_show', methods: ['GET'])]
    public function show(Descriptor $descriptor): Response
    {
        return $this->render('descriptor_crud/show.html.twig', [
            'descriptor' => $descriptor,
        ]);
    }

    #[Route('/{id}/admin/edit', name: 'app_descriptor_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Descriptor $descriptor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DescriptorType::class, $descriptor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_descriptor_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('descriptor_crud/edit.html.twig', [
            'descriptor' => $descriptor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_descriptor_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Descriptor $descriptor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$descriptor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($descriptor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_descriptor_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
