<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\CreateThingCommand;
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
        $thing = new Thing($command->getJson());
        $thing->setBrand(date('H:i:s')); // mocking brand name (it is only a date, I know)
        $this->thingRepository->save($thing);
        return $thing;
    }
}