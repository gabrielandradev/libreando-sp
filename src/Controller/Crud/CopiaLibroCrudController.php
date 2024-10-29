<?php

namespace App\Controller\Crud;

use App\Entity\Libro;
use App\Entity\CopiaLibro;
use App\Form\CopiaLibroType;
use App\Repository\CopiaLibroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/libros/{id}/copias')]
final class CopiaLibroCrudController extends AbstractController
{

}
