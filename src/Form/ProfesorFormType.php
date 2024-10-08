<?php

namespace App\Form;

use App\Entity\Profesor;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfesorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', NumberType::class , [
                'label'    => 'DNI',
                'html5'    => true,
                'required' => true,
                'input' => 'string',
                'attr' => [
                    'maxLength' => 8
                ]
            ])
            ->add('nombre')
            ->add('apellido')
            ->add('domicilio')
            ->add('telefono')
            ->add('area_especialidad')
            ->add('usuario', RegistrationFormType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profesor::class,
        ]);
    }
}
