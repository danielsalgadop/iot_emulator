<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class SearchThingByIdHandler
{

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(SearchThingByIdCommand $command):Thing
    {

        $id = $command->getId();
        $thing = $this->thingRepository->searchThingById($id);
        return $thing;
    }
}