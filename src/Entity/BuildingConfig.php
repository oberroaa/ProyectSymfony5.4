<?php

namespace App\Entity;

use App\Repository\BuildingConfigRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuildingConfigRepository::class)
 */
class BuildingConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $collection;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $template;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level_min;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level_max;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $damage;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $armor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $population;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $time_building;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=BuildingPlayer::class, mappedBy="building")
     */
    private $buildingPlayers;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $capacity;

    /**
     * BiuldingConfig constructor.
     */
    public function __construct()
    {
        $this->capacity = 0;//cantidad de contructores
        $this->level_min = 1;
        $this->level_max = 3;
        $this->damage = 0;
        $this->armor = 0;
        $this->population = 0;//cantidad de poblacion
        $this->time_building = 5;//segundos
        $this->status = 'staking';//staking
        $this->buildingPlayers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;   // TODO: Implement __toString() method.
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollection(): ?string
    {
        return $this->collection;
    }

    public function setCollection(?string $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevelMin(): ?int
    {
        return $this->level_min;
    }

    public function setLevelMin(?int $level_min): self
    {
        $this->level_min = $level_min;

        return $this;
    }

    public function getLevelMax(): ?int
    {
        return $this->level_max;
    }

    public function setLevelMax(?int $level_max): self
    {
        $this->level_max = $level_max;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getDamage(): ?float
    {
        return $this->damage;
    }

    public function setDamage(?float $damage): self
    {
        $this->damage = $damage;

        return $this;
    }

    public function getArmor(): ?float
    {
        return $this->armor;
    }

    public function setArmor(?float $armor): self
    {
        $this->armor = $armor;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(?int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getTimeBuilding(): ?int
    {
        return $this->time_building;
    }

    public function setTimeBuilding(?int $time_building): self
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

    /**
     * @return Collection|BuildingPlayer[]
     */
    public function getBuildingPlayers(): Collection
    {
        return $this->buildingPlayers;
    }

    public function addBuildingPlayer(BuildingPlayer $buildingPlayer): self
    {
        if (!$this->buildingPlayers->contains($buildingPlayer)) {
            $this->buildingPlayers[] = $buildingPlayer;
            $buildingPlayer->setBuilding($this);
        }

        return $this;
    }

    public function removeBuildingPlayer(BuildingPlayer $buildingPlayer): self
    {
        if ($this->buildingPlayers->removeElement($buildingPlayer)) {
            // set the owning side to null (unless already changed)
            if ($buildingPlayer->getBuilding() === $this) {
                $buildingPlayer->setBuilding(null);
            }
        }

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
}
