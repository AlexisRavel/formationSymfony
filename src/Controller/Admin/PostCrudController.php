<?php

namespace App\Controller\Admin;

use App\Entity\Post;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class PostCrudController extends AbstractCrudController {
    public static function getEntityFqcn(): string {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud
                ->setEntityLabelInSingular('Publication')
                ->setEntityLabelInPlural('Les publications')
                ->setPageTitle(crud::PAGE_NEW, "Ajouter une publication")
                ->setPageTitle(crud::PAGE_EDIT, "Modifier une publication");
    }

    public function configureFields(string $pageName): iterable {
        yield AssociationField::new('tags');
        yield TextField::new('title', "Titre");
        yield TextField::new('slug', "Lien");
        yield TextField::new('summary', "Résumé");
        yield TextareaField::new('content', "Contenu")->hideOnIndex();
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
