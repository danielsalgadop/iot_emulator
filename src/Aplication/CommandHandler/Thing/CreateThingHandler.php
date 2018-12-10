<?php

namespace App\Aplication\CommandHandler\Thing;


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
        $thing = new Thing($command->json);
        $this->thingRepository->save($thing);
        return $thing;
    }
}