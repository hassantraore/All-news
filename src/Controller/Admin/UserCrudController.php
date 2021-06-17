<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\Migrations\Configuration\Migration\JsonFile;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureActions(Actions $actions): Actions
    {
        $detailUser= Action::new("","Detail","fa fa-glob");
        $detailUser->linkToCrudAction(Crud::PAGE_DETAIL);
        $detailUser->addCssClass("btn btn-info");



        return $actions
            ->setPermission(Action::DELETE,"ROLE_ADMIN")
            ->add(Crud::PAGE_INDEX,$detailUser);


    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnDetail(),
            TextField::new('username'),
            ArrayField::new('roles'),
            EmailField::new('email')
        ];
    }

}
