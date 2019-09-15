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

    public function handle(SearchThingByIdCommand $searchThingByIdCommand): Thing
    {

        $id = $searchThingByIdCommand->getId();
        $thing = $this->thingRepository->searchThingByIdOrException($id);
        $user = $thing->getUser();
        $user->correctCredentialsOrException($searchThingByIdCommand->getUser(),$searchThingByIdCommand->getPassword());
        return $thing;
    }
}