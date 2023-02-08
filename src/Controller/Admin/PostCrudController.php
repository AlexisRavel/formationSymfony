<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use DateTime;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Crud, KeyValueStore};
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;

use Symfony\Component\Form\{FormBuilderInterface, FormEvents};

class PostCrudController extends AbstractCrudController {
    public static function getEntityFqcn(): string {
        return Post::class;
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        return $this->addFieldEventListener($formBuilder);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
        return $this->addFieldEventListener($formBuilder);
    }

    private function addFieldEventListener(FormBuilderInterface $formBuilder): FormBuilderInterface {
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->manageField());
    }

    private function manageField() {
        return function($event) {
            $form = $event->getForm();
            if(!$form->isValid()) {
                return;
            }

            $form->getData()->setAuteur($this->getUser());
        };
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
