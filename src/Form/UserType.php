<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Construye el formulario
        $builder
            ->add('email') // Añade el campo de email
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN', // Opción para rol de administrador
                    'User' => 'ROLE_USER', // Opción para rol de usuario
                ],
                'multiple' => true, // Permite seleccionar múltiples roles
                'expanded' => false, // Usa un menú desplegable
            ])
            ->add('password') // Añade el campo de contraseña
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Configura las opciones del formulario
        $resolver->setDefaults([
            'data_class' => User::class, // Establece la clase de datos como User
        ]);
    }
}
