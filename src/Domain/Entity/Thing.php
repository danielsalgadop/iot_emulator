<?php

namespace App\Domain\Entity;

use App\Domain\Dto\UserCredentialsDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Entity\Action;
use App\Domain\Entity\Property;
use Symfony\Component\DependencyInjection\Tests\Fixtures\StdClassDecorator;

//use App\Domain\Entity\BasicThing
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


    public static function isIntegrityValidOnCreate(array $data): bool{
        if(
            isset($data['brand']) &&
            isset($data['name']) &&
            isset($data['links']['actions']) &&
            isset($data['links']['properties'])
        )
        {
            return true;
        }
        return false;
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




    public static function hasActionsAndPropertiesConcordance(array $actions, array $properties): bool
    {

        if (count($actions) !== count($properties)) {
            return false;
        }
        for ($i = 0; $i < count($actions); $i++) {
            if (!isset($properties[$i][$actions[$i]] )) {
                return false;
            }
        }
        return true;
    }

    public function searchOutput(){
        // TODO better json {} creation- https://stackoverflow.com/questions/3281354/create-json-object-the-correct-way
        $obj = new \stdClass();
        $obj->id = $this->id;
        $obj->name = $this->name;
        $obj->brand = $this->brand;
        return $obj;
    }

    // named constructor
    public static function createThingFromArray(array $array, UserCredentialsDTO $UserCredentialsDTO): Thing{



        //$name,$brand,$actionCollector, User $user

        // validate
        if(!Thing::isIntegrityValidOnCreate($array)){
            throw new Exception('missing data for Thing creation');
        }

        if(!Thing::hasActionsAndPropertiesConcordance($array['links']['actions'], $array['links']['properties'])){
            throw new Exception("No concordance for Actions and Properties");
        }

        $actionCollector = [];
        for ($i = 0; $i < count($array['links']['actions']); $i++) {
            $action = new Action();
            $property = new Property();

//            $property->setValue($array['links']['properties'][$i][$array['links']['actions'][$i]]);  // madre mia, muy enrevesado!
            $property->setValue('ivan orihola');
            $action->setProperty($property);
            $action->setName($array['links']['actions'][$i]);
            $actionCollector[] = $action;
        }

        /*foreach ($array->links->actions as $actionName) {
        $action = new Action();
        $property = new Property();
        $property->setValue($actionName);  // we asume properties born with action name
        $action->setProperty($property);
        $action->setName($actionName);
        $actionCollector[] = $action;
        */
        $user = new User();
        $user->setName($UserCredentialsDTO->getName());
        $user->setPassword($UserCredentialsDTO->getPassword());

        // DUDA. esto ¿tiene q ser en este orden? crear User -> Crear Thing -> crear relacion user->setThing
        // entiendo que dentro de Thing__construct valdria con hacer un $this->setUser, ¿no?
        $thing = new Thing($array['name'],$array['brand'],$actionCollector,$user);
        $user->setThing($thing);
        return $thing;
//        $this->thingRepository->save($thing);
//        return new Thing();
    }

    public static function publicInfoAsObject(Thing $thing): \stdClass {
        $publicThingInfo = new \stdClass();
        $publicThingInfo->id = $thing->id;
        $publicThingInfo->name = $thing->name;
        $publicThingInfo->brand = $thing->brand;
        return $publicThingInfo;
    }
}
