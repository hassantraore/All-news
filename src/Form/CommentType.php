<?php


namespace App\Form;


use App\Entity\Comment;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add("authorName",TextType::class,["label"=>"Pseudo"])
            ->add("content",TextareaType::class,["label"=>"AJOUTER UN COMMENTAIRE"]);
            //->add("pseudo",TextType::class,["label"=>"Pseudo"]);
            //->add("address",TextType::class,["label"=>"Adresse de messagerie*"])
            //->add("site",TextType::class,["label"=>"Site web"]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA,function (FormEvent $event){
            if($event->getData()->getUser()!==null){
                return;
            }
          $event->getForm()->add("authorName",TextType::class,["label"=>"Pseudo:"]);
        });




    }
     public function configureOptions(OptionsResolver $resolver)
     {
         $resolver->setDefault("data_class",Comment::class);



}
}