<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\ActionRepository")
 */
class Action
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Thing", inversedBy="actions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $IdThing;


    /**
     * @ORM\OneToOne(targetEntity="App\Domain\Entity\Property", mappedBy="idAction", cascade={"persist", "remove"})
     */
    private $property;


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

    public function getIdThing(): ?Thing
    {
        return $this->IdThing;
    }

    public function setIdThing(?Thing $IdThing): self
    {
        $this->IdThing = $IdThing;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(Property $property): self
    {
        $this->property = $property;

        // set the owning side of the relation if necessary
        if ($this !== $property->getIdAction()) {
                $property->setIdAction($this);
            }

        return $this;
    }


}