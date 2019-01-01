<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Property;
use App\Domain\Repository\ThingRepository;

class CreateThingHandler
{

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(CreateThingCommand $command):Thing
    {
        $objData = Thing::validJson($command->getJson());
        $actionCollector = [];

        foreach ($objData->links->actions as $actionName) {
            $action = new Action();
            $property = new Property();
            $property->setValue($actionName);  // we asume properties born with action name
            $action->setProperty($property);
            $action->setName($actionName);
            $actionCollector[] = $action;
        }

        $thing = new Thing($objData->name,$objData->brand,$actionCollector);
        $this->thingRepository->save($thing);
        return $thing;
    }
}