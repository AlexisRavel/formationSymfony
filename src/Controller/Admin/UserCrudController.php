<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Services\RolesHelper;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud, KeyValueStore};
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

use Symfony\Component\Form\Extension\Core\Type\{PasswordType, RepeatedType};
use Symfony\Component\Form\{FormBuilderInterface, FormEvent, FormEvents};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController {
    public function __construct(private RolesHelper $rolesHelper, private UserPasswordHasherInterface $userPasswordHasher) {

    }

    public static function getEntityFqcn(): string {
        return User::class;
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
            $password = $form->get('password')->getData();
            if($password === null) {
                return;
            }

            $form->getData()->setPassword($this->hashPassword($password));
            $form->getData()->setRoles($this->manageRoles($form));
        };
    }

    private function hashPassword($password): string {
        return $this->userPasswordHasher->hashPassword($this->getUser(), $password);
    }
    
    private function manageRoles($form): array {
        return array_values($form->get('roles')->getData());
    }

    public function configureFields(string $pageName): iterable {
        yield TextField::new('username', "Nom d'utilisateur");

        yield TextField::new('password')
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe'],
                'mapped' => false,
            ])
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->onlyOnForms();
        
        yield ChoiceField::new('roles')->setChoices($this->rolesHelper->getRoles())->allowMultipleChoices();
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
