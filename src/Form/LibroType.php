<?php

namespace App\Form;

use App\Entity\Autor;
use App\Entity\ClasificacionDecimalDewey;
use App\Entity\Descriptor;
use App\Entity\Libro;
use App\Repository\ClasificacionDecimalDeweyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LibroType extends AbstractType
{
    public function __construct(
        private UrlGeneratorInterface $router,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('autores', EntityType::class, [
                'multiple' => true,
                'autocomplete' => true,
                'class' => Autor::class,
                'by_reference' => false,
                'tom_select_options' => [
                    'create' => true,
                    'delimiter' => ';'
                ],
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'data-custom-autocomplete-url-value' => $this->router->generate('app_autor_crud_new'),
                ],
                'choice_label' => 'nombre'
            ])
            ->add('isbn')
            ->add('editorial')
            ->add('numero_edicion')
            ->add('lugar_edicion')
            ->add('idioma')
            ->add('notas')
            ->add('numero_paginas')
            ->add('publicacion_edicion', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime',
                'by_reference' => true,
            ])
            ->add('descriptor_primario', EntityType::class, [
                'class' => Descriptor::class,
                'choice_label' => 'nombre',
                'autocomplete' => true,
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'data-custom-autocomplete-url-value' => $this->router->generate('app_descriptor_crud_new'),
                ]
            ])
            ->add('descriptores_secundarios', EntityType::class, [
                'multiple' => true,
                'autocomplete' => true,
                'class' => Descriptor::class,
                'by_reference' => false,
                'tom_select_options' => [
                    'create' => true,
                    'delimiter' => ';'
                ],
                'attr' => [
                    'data-controller' => 'custom-autocomplete',
                    'data-custom-autocomplete-url-value' => $this->router->generate('app_descriptor_crud_new'),
                ],
                'choice_label' => 'nombre'
            ])
            ->add('numero_cdd', EntityType::class, [
                'class' => ClasificacionDecimalDewey::class,
                'query_builder' => function (ClasificacionDecimalDeweyRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.numero_cdd', 'ASC');
                },
                'choice_label' => function ($cdd) {
                    return $cdd->getNumeroCdd() . ' - ' . $cdd->getDescripcion();
                },
            ])
            ->add('guardar', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
            ->add('guardarCrearOtro', SubmitType::class, [
                'attr' => [
                    'class' => 'save'
                ],
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
