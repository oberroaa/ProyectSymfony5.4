<?php

namespace App\Entity;

use App\Repository\BuildingPlayerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuildingPlayerRepository::class)
 */
class BuildingPlayer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="biuldingPlayers")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=BuildingConfig::class, inversedBy="buildingPlayers")
     */
    private $building;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time_building;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capacity;

    /**
     * BuildingPlayer constructor.
     */
    public function __construct()
    {
        $fecha = new \DateTime('now');
        $time = $this->getBuilding()->getTimeBiulding();
        $this->time_building = $fecha->modify("+ $time second");
        $this->level = $this->getBuilding()->getLevelMin();
        $this->status = 'building';//building
        $this->capacity = $this->getBuilding()->getCapacity();
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

    public function getBuilding(): ?BuildingConfig
    {
        return $this->building;
    }

    public function setBuilding(?BuildingConfig $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getTimeBuilding(): ?\DateTimeInterface
    {
        return $this->time_building;
    }

    public function setTimeBuilding(?\DateTimeInterface $time_building): self
    {
        $this->time_building = $time_building;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getDamageTotal()
    {
        return $this->getBuilding()->getDamage() * $this->level;
    }

    public function getArmorTotal()
    {
        return $this->getBuilding()->getArmor() * $this->level;
    }

    public function getPopulationTotal()
    {
        return $this->getBuilding()->getPopulation() + pow($this->level,$this->level) ;
    }

    public function getCapacityTotal()
    {
        return $this->getBuilding()->getCapacity() + $this->level;
    }
}
