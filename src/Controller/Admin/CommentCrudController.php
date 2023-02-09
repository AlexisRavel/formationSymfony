<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
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

    public function configureFields(string $pageName): iterable {
        yield AssociationField::new('post');
        yield TextareaField::new('content', "Commentaire")->hideOnIndex();
        yield AssociationField::new('auteur')->hideOnForm();
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
