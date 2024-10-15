<?php

namespace App\Form;

use App\Entity\Autor;
use App\Entity\ClasificacionDecimalDewey;
use App\Entity\DisponibilidadCopiaLibro;
use App\Entity\Descriptor;
use App\Entity\Libro;
use App\Repository\AutorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityManagerInterface;

class LibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('autores', CollectionType::class, [
                'entry_type' => AutorType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('isbn')
            ->add('editorial')
            ->add('numero_edicion')
            ->add('lugar_edicion')
            ->add('idioma')
            ->add('notas')
            ->add('numero_paginas')
            ->add('ubicacion_fisica')
            ->add('publicacion_edicion', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime',
                'by_reference' => true,
            ])
            ->add('descriptor_primario', EntityType::class, [
                'class' => Descriptor::class,
                'choice_label' => 'nombre'
            ])
            ->add('descriptores_secundarios', CollectionType::class, [
                'entry_type' => DescriptorType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('numero_cdd', EntityType::class, [
                'class' => ClasificacionDecimalDewey::class,
                'choice_label' => function ($cdd) {
                    return $cdd->getNumeroCdd() . ' - ' . $cdd->getDescripcion();
                },
            ])
            ->add('numero_copias', NumberType::class, [
                'mapped' => false,
                'html5' => true,
            ])
            ->add('disponibilidad_copias', EntityType::class, [
                'mapped' => false,
                'class' => DisponibilidadCopiaLibro::class,
                'choice_label' => 'estado'
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
