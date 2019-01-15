<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Property;
use App\Domain\Entity\User;
use App\Domain\Repository\ThingRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateThingHandler
{

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(CreateThingCommand $command):Thing
    {

        $actionCollector = [];
        for ($i = 0; $i < count($objData->links->actions); $i++) {
                $action = new Action();
                $property = new Property();

                $property->setValue($objData->links->properties[$i]->{$objData->links->actions[$i]});  // madre mia, muy enrevesado!
                $action->setProperty($property);
                $action->setName($objData->links->actions[$i]);
                $actionCollector[] = $action;
            }

            /*foreach ($objData->links->actions as $actionName) {
            $action = new Action();
            $property = new Property();
            $property->setValue($actionName);  // we asume properties born with action name
            $action->setProperty($property);
            $action->setName($actionName);
            $actionCollector[] = $action;
        }
            */

        $user = new User();
        $user->setName($command->getUser());
        $user->setPassword($command->getPassword());

        // DUDA. esto ¿tiene q ser en este orden? crear User -> Crear Thing -> crear relacion user->setThing
        // entiendo que dentro de Thing__construct valdria con hacer un $this->setUser, ¿no?
        $thing = new Thing($objData->name,$objData->brand,$actionCollector,$user);
        $user->setThing($thing);
        $this->thingRepository->save($thing);
        return $thing;
    }
}