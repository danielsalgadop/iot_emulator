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
        file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export("suspender VOY".$id, true) . PHP_EOL, FILE_APPEND);
        $thing = $this->thingRepository->searchThingByIdOrException($id);

        return $thing;
    }
}