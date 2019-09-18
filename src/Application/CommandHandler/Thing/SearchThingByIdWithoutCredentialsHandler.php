<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\SearchThingByIdWithoutCredentialsCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class SearchThingByIdWithoutCredentialsHandler
{

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(SearchThingByIdWithoutCredentialsCommand $searchThingByIdWithoutCredentialsCommand): Thing
    {
        $id = $searchThingByIdWithoutCredentialsCommand->getId();
        $thing = $this->thingRepository->searchThingByIdOrException($id);

        return $thing;
    }
}
