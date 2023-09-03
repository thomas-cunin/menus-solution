<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        // if user is ROLE_SUPER_ADMIN, show all users
        // if user is ROLE_ADMIN, show only users from his place getPlace()

        $user = $this->getUser();
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            return $queryBuilder;
        }
        return $queryBuilder->andWhere('entity.place = :place')->setParameter('place', $user->getPlace());
    }
//    #[ORM\ManyToOne(inversedBy: 'users')]
//    private ?Place $place = null;
    public function configureFields(string $pageName): iterable
    {
        // if user is ROLE_SUPER_ADMIN he can do everything
        // if user is ROLE_ADMIN he can only edit and delete users from his place getPlace() but he can't edit place relation or change place during creation of users, he can't choose role of user

        $user = $this->getUser();
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            return [
                TextField::new('email'),
                TextField::new('firstName'),
                TextField::new('lastName'),
                AssociationField::new('place'),
                ChoiceField::new('roles')->setChoices(['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER', 'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN'])->allowMultipleChoices(),
            ];
        }
        // if it's for creation we allow to edit data, place is automatically set to user's place getPlace() and role is set to ROLE_USER
        if (Crud::PAGE_NEW === $pageName) {
            return [
                TextField::new('email'),
                TextField::new('firstName'),
                TextField::new('lastName'),
                AssociationField::new('place')->setFormTypeOption('disabled', true),
            ];
        }
        // Si c'est la page d'index (tableau des entités), ne montrez pas le champ 'place'
        if (Crud::PAGE_INDEX === $pageName) {
            return  [
                TextField::new('email'),
                TextField::new('firstName'),
                TextField::new('lastName'),
            ];
        }

        return [
            TextField::new('email')->setFormTypeOption('disabled', true),
            TextField::new('firstName')->setFormTypeOption('disabled', true ),
            TextField::new('lastName')->setFormTypeOption('disabled', true),
            AssociationField::new('place')->setFormTypeOption('disabled', true),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        // if user is ROLE_SUPER_ADMIN he can do everything
        // if user is ROLE_ADMIN he can only edit and delete users from his place getPlace()


        $user = $this->getUser();
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            return $actions;
        }
    return $actions;
    }
// add filters
    public function configureCrud(Crud $crud): Crud
    {
        // if user is ROLE_SUPER_ADMIN he can use evry filter
        // if user is ROLE_ADMIN he can't change place filter

        $user = $this->getUser();
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            return $crud;
        }
        return $crud->setSearchFields(['email', 'firstName', 'lastName']);
    }
}
