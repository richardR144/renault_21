<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
//            ->add('roles')
                        //en dessous c'est pour que le password se hashe à l'entrée quand l'user rentre son mdp
            ->add('password', PasswordType::class, [
                'hash_property_path' => 'password', 'mapped' => false,])
            ->add('name')
            ->add('firstname')
            ->add('save', SubmitType::class, ['label' => 'S\'inscrire'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
