<?php


namespace App\Form;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use  App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class PostType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title",TextType::class,["label"=>"Titre:"])
            ->add("contents",TextareaType::class,["label"=>"Article:"])
            ->add("authorName",TextType::class,["label"=>"Auteur:"])
            ->add("category",EntityType::class,["class"=>Category::class])
            ->add("image",FileType::class,
                ["mapped"=>false,
                    "required"=>false,
                    "constraints"=>[new Image(),
                                    new NotNull(["groups"=>"create"])
                    ]]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault("data_class",Post::class);
    }


}