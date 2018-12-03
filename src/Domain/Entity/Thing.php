<?php
namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
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
