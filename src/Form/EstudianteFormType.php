<?php

namespace App\Form;

use App\Entity\Especialidad;
use App\Entity\Estudiante;
use App\Entity\Turno;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\TelType;

class EstudianteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', NumberType::class, [
                'label'    => 'DNI',
                'html5'    => true,
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 99999999
                ]
            ])
            ->add('nombre')
            ->add('apellido')
            ->add('domicilio')
            ->add('telefono', TelType::class, [
                'label' => 'Teléfono',
                'attr' => [
                    'placeholder' => '11-5555-1234',
                    'pattern' => "[0-9]{2}-[0-9]{4}-[0-9]{4}"
                ]
            ])
            ->add('anio', ChoiceType::class, [
                'label' => 'Año',
                'choices'  => [
                    '1ero' => 1,
                    '2do' => 2,
                    '3ero' => 3,
                    '4to' => 4,
                    '5to' => 5,
                    '6to' => 6,
                ],
                'data' => 1
            ])
            ->add('division')
            ->add('especialidad', EntityType::class, [
                'class' => Especialidad::class,
                'choice_label' => 'nombre',
            ])
            ->add('turno', EntityType::class, [
                'class' => Turno::class,
                'choice_label' => 'nombre',
            ])
            ->add('usuario', RegistrationFormType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estudiante::class,
        ]);
    }
}
