<?php
namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Domain\BasicThing;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ThingRepository")
 */
class Thing extends BasicThing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Action", mappedBy="idThing")
     */
    private $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function setActions($actions): void
    {
        $this->actions = $actions;
    }



    public function getId()
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }



}
