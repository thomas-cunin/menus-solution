<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Flex\Response;

class PlaceCrudController extends AbstractCrudController
{

    // if user is not with role ROLE_SUPER_ADMIN redirect to /admin if he have ROLE_USER
    public static function getEntityFqcn(): string
    {
        return Place::class;
    }
public function index(AdminContext $context)
{
    // if user is not ROLE_SUPER_ADMIN redirect to /admin
    $user = $this->getUser();
    if (!in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
        return $this->redirect('/admin');
    }

    return parent::index($context);
}


    public function configureFields(string $pageName): iterable
    {
        // if page is index and user is ROLE_ADMIN redirect to edit page of his own place
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('adress'),
            ImageField::new('image')->setUploadDir('public/uploads/images')->setRequired(false),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $user = $this->getUser();

        // if user is superadmin, allow all actions
        // if user is admin he can't see place list and can't delete or create place, he only can edit his own place
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            return $actions;
        }

        // if user is admin, he can't be in this crud

        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $user = $this->getUser();

// Si l'utilisateur est un UserAdmin, redirigez-le vers la page d'édition de son propre Place lorsqu'il essaie d'accéder à la liste des Place
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // if it's index page, redirect to edit page of his own place

        }

        return $crud;
    }

}
