<?php

namespace App\Entity;

use App\Repository\PriceQuantityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceQuantityRepository::class)]
class PriceQuantity
{



    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'pricesQuantity')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DishOrDrink $dishOrDrink = null;


    public function __toString(): string
    {
        return $this->getQuantity() . ' - ' . $this->getPrice() . ' €';
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getDishOrDrink(): ?DishOrDrink
    {
        return $this->dishOrDrink;
    }

    public function setDishOrDrink(?DishOrDrink $dishOrDrink): static
    {
        $this->dishOrDrink = $dishOrDrink;

        return $this;
    }
}
