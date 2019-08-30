<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 */
class Property
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
    private $value;

    /**
     * @ORM\OneToOne(targetEntity="App\Domain\Entity\Action", inversedBy="property", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idAction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getIdAction(): ?Action
    {
        return $this->idAction;
    }

    public function setIdAction(Action $idAction): self
    {
        $this->idAction = $idAction;
        return $this;
    }

    public function asArray()
    {
        $class = new \stdClass();
        $class->value = $this->getValue();
        return [
            $class
        ];

    }
}
