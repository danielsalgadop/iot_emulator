<?php

namespace App\Application\CommandHandler\Thing;

use App\Application\Command\Thing\CreateThingCommand;
use App\Domain\Entity\Action;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Property;
use App\Domain\Entity\User;
use App\Domain\Repository\ThingRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateThingHandler
{
    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(CreateThingCommand $command):Thing
    {
        return Thing::createThingFromArray($command->getArray(), $command->getUserDTO());
    }
}
