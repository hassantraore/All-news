<?php


namespace App\Form;


use App\DataTransfertObject\Credentials;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("username", TextType::class,["label"=>"Email"])
            ->add("passwords", PasswordType::class,["label"=>"Password"]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class",Credentials::class);
    }


}