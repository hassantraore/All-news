<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureActions(Actions $actions): Actions
    {


        $detailCategory = Action::new("detailCategory","Detail","fa fa-glob")
            ->linkToCrudAction(Crud::PAGE_DETAIL)
            ->addCssClass("btn btn-info");

        return $actions
            ->setPermission(Action::DETAIL,"ROLE_ADMIN")
            ->add(Crud::PAGE_INDEX,$detailCategory);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnDetail(),
            TextField::new('name'),
            TextEditorField::new('description'),
        ];
    }
    
}