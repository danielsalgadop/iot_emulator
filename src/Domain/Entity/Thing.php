<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Entity\BasicThing;
/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\ThingRepository")
 */
class Thing
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
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Action", mappedBy="IdThing", orphanRemoval=true, cascade={"persist"})
     */
    private $actions;


    /**
    * @ORM\OneToOne(targetEntity="App\Domain\Entity\User", mappedBy="thing", cascade={"persist", "remove"})
    */
    private $user;

    public function __construct($name,$brand,$actionCollector, User $user)
    {
        $this->name = $name;
        $this->brand = $brand;
        $this->actions = new ArrayCollection();
        $this->user = $user;
        // $this->setUser($user);
        foreach ($actionCollector as $action) {
            $this->addAction($action);
        }

    }

    public static function decodeJsonToObjectOrException($json)
    {
        $objJson = json_decode($json);

        if ($objJson === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Bad Json");
        }

        return $objJson;
    }

    public static function validJson($json,$user,$password):object {

        $objData = Thing::decodeJsonToObjectOrException($json);

        if(!isset($objData->brand)){
            throw new \Exception("No Brand found");
        }
        if(!isset($objData->name)){
            throw new \Exception("No Name found");
        }
        if(!isset($objData->links->actions)){
            throw new \Exception("No Actions found");
        }
        if(!isset($objData->links->properties)){
            throw new \Exception("No Properties found");
        }
        if(!isset($user)){
            throw new \Exception("No User found");
        }
        if(!isset($password)){
            throw new \Exception("No Password found");
        }

        return $objData;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        // set the owning side of the relation if necessary
        if ($this !== $user->getIdThing()) {
            $user->setIdThing($this);
        }

        return $this;
    }




    public static function actionsAndPropertiesConcordance($actions, $properties)
    {
        $message = "No concordance for Actions and Properties";
        if (count($actions) !== count($properties)) {
            Throw new \Exception($message);
        }
        for ($i = 0; $i < count($actions); $i++) {
            if (!isset($properties[$i]->{$actions[$i]})) {
                Throw new \Exception($message);
            }
        }
    }

    public function searchOutput(){
        // TODO better json {} creation- https://stackoverflow.com/questions/3281354/create-json-object-the-correct-way
        $obj = new \stdClass();
        $obj->id = $this->id;
        $obj->name = $this->name;
        $obj->brand = $this->brand;
        return $obj;
    }
}
