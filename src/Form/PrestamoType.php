<?php

namespace App\Form;

use App\Entity\CopiaLibro;
use App\Entity\EstadoPrestamo;
use App\Entity\Prestamo;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestamoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_solicitud', null, [
                'widget' => 'single_text',
            ])
            ->add('fecha_prestamo', null, [
                'widget' => 'single_text',
            ])
            ->add('fecha_devolucion', null, [
                'widget' => 'single_text',
            ])
            ->add('copia_libro', EntityType::class, [
                'class' => CopiaLibro::class,
                'choice_label' => 'id',
            ])
            ->add('prestatario', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'id',
            ])
            ->add('estado_prestamo', EntityType::class, [
                'class' => EstadoPrestamo::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestamo::class,
        ]);
    }
}