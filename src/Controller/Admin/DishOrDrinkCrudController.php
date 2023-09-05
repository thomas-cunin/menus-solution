<?php

namespace App\Controller\Admin;

use App\Admin\Field\TinyMCEField;
use App\Entity\DishOrDrink;
use App\Form\PriceQuantityType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use SebastianBergmann\CodeCoverage\Report\Text;

class DishOrDrinkCrudController extends AbstractCrudController
{
//    #[ORM\Column(length: 255)]
//    private ?string $name = null;
//
//    #[ORM\Column(type: Types::ARRAY)]
//    private array $prices = [];
//
//    #[ORM\Column(length: 255, nullable: true)]
//    private ?string $description = null;
//
//    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'dishOrDrinks')]
//    private Collection $categories;
//
//    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'dishOrDrinks')]
//    private Collection $menus;
    public static function getEntityFqcn(): string
    {
        return DishOrDrink::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextareaField::new('description'),
            // add choice of type 'DISH', 'DRINK', 'MENU'
            ChoiceField::new('type')
                ->setChoices([
                    'Plat' => DishOrDrink::DISH_TYPE,
                    'Boisson' => DishOrDrink::DRINK_TYPE,
                    'Menu' => DishOrDrink::MENU_TYPE,
                ]),

            CollectionField::new('pricesQuantity')
                ->setEntryType(PriceQuantityType::class)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]),

        ];
    }
}
