<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class CreateThingHandler
{

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

//    public function handle():Thing
    public function handle(CreateThingCommand $command):Thing
    {
        $thing = new Thing();
        $json = $command->getJson();
        $objJson = json_decode($json);

        $thing->setBrand($objJson->brand);

        foreach ($objJson->actions as $actionName) {
            $action = new Action();
            $action->setName($actionName);
            $thing->addAction($action);
        }
        $this->thingRepository->save($thing);
        return $thing;
    }
}