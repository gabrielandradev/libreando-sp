<?php

namespace App\Form;

use App\Entity\Administrador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints\NotBlank;

class AdministradorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $optionsz): void
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
            'required' => true
        ])
        ->add('apellido', TextType::class, [
            'required' => true
        ])
        ->add('domicilio', TextType::class, [
            'required' => true
        ])
        ->add('telefono', TelType::class, [
            'label' => 'Teléfono',
            'attr' => [
                'placeholder' => '11-5555-1234',
                'pattern' => "[0-9]{2}-[0-9]{4}-[0-9]{4}"
            ]
        ])
            ->add('funcion', TextType::class, [
                'required' => true
            ])
            ->add('usuario', RegistrationFormType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Administrador::class,
        ]);
    }
}
