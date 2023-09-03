<?php

namespace App\Entity;

use App\Repository\DishOrDrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishOrDrinkRepository::class)]
class DishOrDrink
{
    const DISH_TYPE = 'DISH';
    const DRINK_TYPE = 'DRINK';
    const MENU_TYPE = 'MENU';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $prices = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'dishOrDrinks')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'dishOrDrinks')]
    private Collection $menus;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'dishOrDrink', targetEntity: PriceQuantity::class, cascade: ["persist"], orphanRemoval: true)]
    private Collection $pricesQuantity;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->pricesQuantity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrices(): array
    {
        return $this->prices;
    }

    public function setPrices(array $prices): static
    {
        $this->prices = $prices;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addDishOrDrink($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeDishOrDrink($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->addDishOrDrink($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): static
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeDishOrDrink($this);
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, PriceQuantity>
     */
    public function getPricesQuantity(): Collection
    {
        return $this->pricesQuantity;
    }

    public function addPricesQuantity(PriceQuantity $pricesQuantity): static
    {
        if (!$this->pricesQuantity->contains($pricesQuantity)) {
            $this->pricesQuantity->add($pricesQuantity);
            $pricesQuantity->setDishOrDrink($this);
        }

        return $this;
    }

    public function removePricesQuantity(PriceQuantity $pricesQuantity): static
    {
        if ($this->pricesQuantity->removeElement($pricesQuantity)) {
            // set the owning side to null (unless already changed)
            if ($pricesQuantity->getDishOrDrink() === $this) {
                $pricesQuantity->setDishOrDrink(null);
            }
        }

        return $this;
    }
}
