<?php

namespace App\Form;

use App\Entity\Autor;
use App\Entity\ClasificacionDecimalDewey;
use App\Entity\Descriptor;
use App\Entity\Libro;
use App\Repository\AutorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\Extension\DatalistExtension;
use Doctrine\ORM\EntityManagerInterface;

class LibroType extends AbstractType
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('autores', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => [
                    'datalist' => $this->entityManager->getRepository(Autor::class)->findAll()
                ],
            ])
            ->add('isbn')
            ->add('editorial')
            ->add('numero_edicion')
            ->add('lugar_edicion')
            ->add('idioma')
            ->add('notas')
            ->add('numero_paginas')
            ->add('ubicacion_fisica')
            ->add('publicacion_edicion', null, [
                'widget' => 'single_text',
            ])
            ->add('descriptor_primario', TextType::class, [
                'datalist' => $this->entityManager->getRepository(Descriptor::class)->findAll()
            ])
            ->add('descriptores_secundarios', CollectionType::class, [
                'entry_type' => TextType::class,
                'entry_options' => [
                    'datalist' => $this->entityManager->getRepository(Descriptor::class)->findAll()
                ],
            ])
            ->add('numero_cdd', EntityType::class, [
                'class' => ClasificacionDecimalDewey::class,
                'choice_label' => function ($cdd) {
                    return $cdd->getNumeroCdd() . ' - ' . $cdd->getDescripcion();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }
}
