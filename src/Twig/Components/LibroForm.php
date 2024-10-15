<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use App\Entity\Libro;
use App\Form\LibroType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;

#[AsLiveComponent]
final class LibroForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?Libro $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(LibroType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function addAutor()
    {
        $this->formValues['autores'][] = [];
    }

    #[LiveAction]
    public function removeAutor(#[LiveArg] int $index)
    {
        unset($this->formValues['autores'][$index]);
    }

    #[LiveAction]
    public function addDescriptorSecundario()
    {
        $this->formValues['descriptores_secundarios'][] = [];
    }

    #[LiveAction]
    public function removeDescriptorSecundario(#[LiveArg] int $index)
    {
        unset($this->formValues['descriptores_secundarios'][$index]);
    }
}
