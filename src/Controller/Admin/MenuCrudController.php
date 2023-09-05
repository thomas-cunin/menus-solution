<?php

namespace App\Controller\Admin;

use App\Admin\Field\TinyMCEField;
use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('place');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TinyMCEField::new('content'),
        ];
    }
}
