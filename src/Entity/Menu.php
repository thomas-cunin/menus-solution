<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'menus')]
    private ?Place $place = null;

    #[ORM\ManyToMany(targetEntity: DishOrDrink::class, inversedBy: 'menus')]
    private Collection $dishOrDrinks;

    public function __construct()
    {
        $this->dishOrDrinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): static
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection<int, DishOrDrink>
     */
    public function getDishOrDrinks(): Collection
    {
        return $this->dishOrDrinks;
    }

    public function addDishOrDrink(DishOrDrink $dishOrDrink): static
    {
        if (!$this->dishOrDrinks->contains($dishOrDrink)) {
            $this->dishOrDrinks->add($dishOrDrink);
        }

        return $this;
    }

    public function removeDishOrDrink(DishOrDrink $dishOrDrink): static
    {
        $this->dishOrDrinks->removeElement($dishOrDrink);

        return $this;
    }
}
