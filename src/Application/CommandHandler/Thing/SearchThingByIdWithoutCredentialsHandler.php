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

    public function handle(SearchThingByIdWithoutCredentialsCommand $sxearchThingByIdWithoutCredentialsCommand): Thing
    {
        return "rrrrrr";
        $id = $searchThingByIdWithoutCredentialsCommand->getId();
        print $id;
        exit;
        $thing = $this->thingRepository->searchThingByIdOrException($id);
        return $thing;
    }
}