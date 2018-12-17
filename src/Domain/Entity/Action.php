<?php


namespace App\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;
//use App\Domain\Entity\Thing;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
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
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Thing", inversedBy="actions")
     */
    private $idThing;

    public function getIdThing()
    {
        return $this->idThing;
    }

    public function setIdThing($idThing): void
    {
        $this->idThing = $idThing;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
        // DUDA devolver $thing?
    }


    public function getId()
    {
        return $this->id;
    }

    public function getAction(): string
    {
        return $this->action;
        // DUDA devolver $thing?
    }

    public function setAction($action): void
    {
        $this->action = $action;
    }


}
