<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\PostType;
use App\Uploads\UploaderInterface;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use function Sodium\add;
use Symfony\Component\Routing\Annotation\Route;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }






    public function configureActions(Actions $actions): Actions
    {
       $detailUser = Action::new("detailUser"," Detail","fa fa-user");
       $detailUser->linkToCrudAction(Crud::PAGE_DETAIL);
       $detailUser->addCssClass("btn btn-info");





        return $actions
            ->setPermission(Action::DELETE,"ROLE_ADMIN")
            ->add(Crud::PAGE_INDEX,$detailUser);


    }


    public function configureFields(string $pageName): iterable
    {
        $imageFile = TextareaField::new('imageFile')
            ->setFormType(VichImageType::class)
            ->setLabel("image")
            //->hideOnIndex()
            ->setFormTypeOption('allow_delete',false);

        $image = ImageField::new('image')
            ->setBasePath("/uploads")
            ->setLabel("image")
          //->hideOnIndex()
            ->setFormTypeOption('allow_delete',false);


        $fileds = [
            IntegerField::new('id', 'ID')->onlyOnDetail(),
            TextField::new('title',"Titre"),
            TextField::new('slug'),
            TextField::new('authorName',"Auteur"),
            TextEditorField::new('contents',"Contenu"),
            TextField::new("category","Catégorie"),
        ];

        if($pageName===Crud::PAGE_INDEX|| $pageName===Crud::PAGE_DETAIL){
            $fileds[] =$image ;
        }
        else{
            $fileds[] =$imageFile;

        }
        return $fileds;
    }

}
