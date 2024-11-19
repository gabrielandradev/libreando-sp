<?php

namespace App\Form;

use App\Entity\Profesor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    
class ProfesorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', NumberType::class, [
                'label'    => 'DNI',
                'html5'    => true,
                'required' => true,
                'input' => 'string',
                'help' => 'Sin puntos ni espacios', 
                'attr' => [
                    'maxLength' => 8
                ]
            ])
            ->add('nombre', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Ingrese un nombre'),
                ]
            ])
            ->add('apellido', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Ingrese un nombre'),
                ]
            ])
            ->add('domicilio', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Ingrese un nombre'),
                ]
            ])
            ->add('telefono', TelType::class, [
                'label' => 'Teléfono',
                'attr' => [
                    'placeholder' => '11-5555-1234',
                    'pattern' => "[0-9]{2}-[0-9]{4}-[0-9]{4}"
                ]
            ])
            ->add('area_especialidad', TextareaType::class, [
                'label' => 'Área de especialidad',
                'help' => 'Describe brevemente el área en la que te especializas'
            ])
            ->add('usuario', RegistrationFormType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profesor::class,
        ]);
    }
}
