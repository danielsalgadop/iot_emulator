<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class CreateThingHandler
{
    private $postRepository;

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(CreateThingCommand $command):Thing
    {
//        $thing = Thing::create($command->title(), $command->body());
        $thing = new Thing();
        var_dump($command->getJson());
//        $actions = [new Action('action1'),new Action('action2')];




//        $action = $command->getActions();
//        $thing->setActions(json_decode($command->getJson());
//        $thing->setActions(new Action('action1'));
        $action = new Action();
        $action->setAction('ActionHardCoded');
        $thing->setActions(['HCasArray']);
        $thing->setBrand(date('H:i:s')); // mocking brand name (it is only a date, I know)
        $this->thingRepository->save($thing);
        return $thing;
    }
}