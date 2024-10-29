<?php

namespace App\Form;

use App\Entity\CopiaLibro;
use App\Entity\DisponibilidadCopiaLibro;
use App\Entity\Libro;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CopiaLibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ubicacion_fisica')
            ->add('disponibilidad', EntityType::class, [
                'class' => DisponibilidadCopiaLibro::class,
                'choice_label' => 'estado',
            ])
            ->add('guardar_multiple', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('numero_copias', NumberType::class, [
                'html5'    => true,
                'mapped' => false,
                'required' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CopiaLibro::class,
        ]);
    }
}
