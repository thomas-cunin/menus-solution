<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: DishOrDrink::class, inversedBy: 'categories')]
    private Collection $dishOrDrinks;

    public function __construct()
    {
        $this->dishOrDrinks = new ArrayCollection();
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
