<?php


namespace App\Form;


use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',TextType::class,["label"=>"email"])
            ->add('name',TextType::class,["label"=>"nom"])
            ->add('plainPassword',RepeatedType::class,["type"=>PasswordType::class,
            'mapped'=>false,
                'first_options'=>['label'=>'mot de passe:'],
                'second_options'=>['label'=>'confirmez mot de passe:'],
                'invalid_message'=>'la confirmation n\'est pas similaire au mot de passe.',
                 'constraints'=>[new NotBlank(),
                                 new Length(['max'=>8])]

                ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("date_class",Admin::class);

    }


}