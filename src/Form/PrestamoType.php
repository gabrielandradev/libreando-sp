<?php

namespace App\Form;

use App\Entity\CopiaLibro;
use App\Entity\EstadoPrestamo;
use App\Entity\Prestamo;
use App\Entity\Usuario;
use App\Entity\Libro;
use App\Repository\CopiaLibroRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class PrestamoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('prestatario', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'email',
            ])
            ->add('libro', EntityType::class,  [
                'multiple' => true,
                'autocomplete' => true,
                'class' => Libro::class,
                'by_reference' => false,
                'choice_label' => 'nombre',
                'mapped' => false
            ])
            ->addDependent('copia_libro', 'libro', function (DependentField $field, ?Libro $libro) {
                $field->add(EntityType::class, [
                    'class' => CopiaLibro::class,
                    'placeholder' => null === $libro ? 'Selecciona un libro primero' : $libro->getTitulo(),
                    'choice_label' => fn (CopiaLibro $copia_libro): string => $copia_libro->getId(),
                    'disabled' => null === $libro,
                    'autocomplete' => true,
                ]);
            })
            ->add('fecha_devolucion', null, [
                'widget' => 'single_text',
            ])

            ->add('estado_prestamo', EntityType::class, [
                'class' => EstadoPrestamo::class,
                'choice_label' => 'estado',
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
