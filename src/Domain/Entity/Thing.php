<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Entity\BasicThing;
/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\ThingRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Action", mappedBy="IdThing", orphanRemoval=true, cascade={"persist"})
     */
    private $actions;

    public function __construct($objData)
    {
        parent::__construct($objData);
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
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

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setIdThing($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getIdThing() === $this) {
                $action->setIdThing(null);
            }
        }

        return $this;
    }

    public function searchOutput(){
        $obj = new \stdClass();
        $obj->id = $this->id;
        $obj->name = $this->name;
        $obj->brand = $this->brand;
        return $obj;
    }
}
