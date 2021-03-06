<?php

namespace App\Entity\Admin;

use App\Entity\User;
use App\Repository\Admin\OrderRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=OrderDetail::class, mappedBy="myOrder")
     */
    private $orderDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripSessionId;

    /**
     * @ORM\Column(type="time")
     */
    private $wantedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|OrderDetail[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetail $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails[] = $orderDetail;
            $orderDetail->setMyOrder($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetail $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getMyOrder() === $this) {
                $orderDetail->setMyOrder(null);
            }
        }

        return $this;
    }

    public function getStripSessionId(): ?string
    {
        return $this->stripSessionId;
    }

    public function setStripSessionId(?string $stripSessionId): self
    {
        $this->stripSessionId = $stripSessionId;

        return $this;
    }

    public function getWantedAt(): ?\DateTimeInterface
    {
        return $this->wantedAt;
    }

    public function setWantedAt(\DateTimeInterface $wantedAt): self
    {
        $this->wantedAt = $wantedAt;

        return $this;
    }
}
