<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Estudiante;
use App\Entity\Profesor;
use App\Form\RegistrationFormType;
use App\Form\EstudianteFormType;
use App\Form\ProfesorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registro', name: 'app_registro')]
    public function register(): Response
    {
        return $this->render('registration/registro_picker.html.twig');
    }

    #[Route('/registro/estudiantes', name: 'app_registro_estudiantes')]
    public function registrarEstudiante(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) {
        $usuario = new Usuario();
        $estudiante = new Estudiante();

        $form = $this->createForm(EstudianteFormType::class, $estudiante);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $userEntity = $form->get('usuario');
            $plainPassword = $userEntity->get('plainPassword')->getData();

            $usuario->setEmail($userEntity->get('email')->getData());

            // encode the plain password
            $usuario->setPassword($userPasswordHasher->hashPassword($usuario, $plainPassword));

            $usuario->setEsUsuarioActivo(false);

            $usuario->setRoles(['ROLE_STUDENT']);

            $estudiante->setUsuario($usuario);

            $entityManager->persist($usuario);
            $entityManager->persist($estudiante);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('registration/registro_estudiante.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/registro/profesores', name: 'app_registro_profesores')]
    public function registrarProfesor(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) {
        $usuario = new Usuario();
        $profesor = new Profesor();

        $form = $this->createForm(ProfesorFormType::class, $profesor);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $userEntity = $form->get('usuario');
            $plainPassword = $userEntity->get('plainPassword')->getData();

            $usuario->setEmail($userEntity->get('email')->getData());

            // encode the plain password
            $usuario->setPassword($userPasswordHasher->hashPassword($usuario, $plainPassword));

            $usuario->setEsUsuarioActivo(false);

            $usuario->setRoles(['ROLE_TEACHER']);

            $profesor->setUsuario($usuario);

            $entityManager->persist($usuario);
            $entityManager->persist($profesor);
            $entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('registration/registro_profesor.html.twig', [
            'form' => $form,
        ]);
    }
}
