<?php

namespace App\Aplication\CommandHandler\Thing;


use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Thing;
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
        $thing = Thing::create($command->title(), $command->body());
        $this->thingRepository->save($thing);
        return $thing;
    }
}