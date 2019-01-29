<?php

namespace App\Domain\Entity;

use App\Application\Dto\UserCredentialsDTO;
use App\Infrastructure\Thing\Serializer\ThingWithoutCredentials;
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

    public function getBrand()
    {
        return $this->brand;
    }

    public function getName()
    {
        return $this->name;
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

    // named constructor

    public static function createThingFromArray(array $array, UserCredentialsDTO $UserCredentialsDTO): Thing{

        // validate
        if(!Thing::isIntegrityValidOnCreate($array)){
            throw new \Exception('missing data for Thing creation');
        }

        if(!Thing::hasActionsAndPropertiesConcordance($array['links']['actions'], $array['links']['properties'])){
            throw new \Exception("No concordance for Actions and Properties");
        }

        $actionCollector = [];
        for ($i = 0; $i < count($array['links']['actions']); $i++) {
            $action = new Action();
            $property = new Property();

            $property->setValue($array['links']['properties'][$i][$array['links']['actions'][$i]]); // madre mia, muy enrevesado!
            $action->setProperty($property);
            $action->setName($array['links']['actions'][$i]);
            $actionCollector[] = $action;
        }

        $user = new User();
        $user->setName($UserCredentialsDTO->getName());
        $user->setPassword($UserCredentialsDTO->getPassword());

        // DUDA. esto ¿tiene q ser en este orden? crear User -> Crear Thing -> crear relacion user->setThing
        // entiendo que dentro de Thing__construct valdria con hacer un $this->setUser, ¿no?
        $thing = new Thing($array['name'],$array['brand'],$actionCollector,$user);
        $user->setThing($thing);
        return $thing;
    }

    public static function publicInfoAsObject(Thing $thing): \stdClass {
        $obj = new \stdClass();
        $obj->id = $thing->id;
        $obj->name = $thing->name;
        $obj->brand = $thing->brand;
        return $obj;
    }

        // TODO better json {} creation- https://stackoverflow.com/questions/3281354/create-json-object-the-correct-way
    public static function privateInfoAsObject(Thing $thing){
        $obj2 = ThingWithoutCredentials::asObject($thing);
        $obj = Thing::publicInfoAsObject($thing);
        $actions = $thing->getActions();
        $obj->actions['link'] = "/actions";
        foreach ($actions as $action){
            $property = $action->getProperty();
            $obj->actions['resources'][$action->getName()]['values'] = $property->getValue();
        }
        return $obj2;
        return $obj;
    }
}
