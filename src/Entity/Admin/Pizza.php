<?php

namespace App\Entity\Admin;


use App\Repository\Admin\PizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PizzaRepository::class)
 * @UniqueEntity("name")
 */
class Pizza
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="une pizza doit avoir un nom")
     * @Assert\Length(min=4 ,minMessage="au moin {{ limit }} caractere",
     *     max=50, maxMessage="au maximum {{ limit }} caractere")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="une pizza doit avoir un prix")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity=Ingredient::class, inversedBy="pizzas")
     */
    private $ingredients;

    /**
     * @ORM\ManyToOne(targetEntity=BasePizza::class, inversedBy="pizzas")
     */
    private $basePizza;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;





    public function __construct()
    {
        $this->ingredients = new ArrayCollection();


    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getBasePizza(): ?BasePizza
    {
        return $this->basePizza;
    }

    public function setBasePizza(?BasePizza $basePizza): self
    {
        $this->basePizza = $basePizza;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }



    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }




}
