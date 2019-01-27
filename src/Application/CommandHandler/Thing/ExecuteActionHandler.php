<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\ExecuteActionCommand;
use App\Domain\Entity\Thing;
use App\Domain\Repository\ThingRepository;

class ExecuteActionHandler
{

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(ExecuteActionCommand $command)
    {
        $thing = $command->getThing();

        // Check if action exists and remove it if it does. Or exception if it does not

        $arrayOfPropertiesAndValues = $command->getArrayOfPropertyNameAndValue();

        foreach ($thing->getActions() as $action){
            $action_name = $action->getName();
            if($action->getName() === $command->getAction()){

                $property = $action->getProperty();
                // We are assuming 1 action has 1 property
                if(!isset($arrayOfPropertiesAndValues[$action_name])){
                    throw new \Exception("Non-existing Property to update");
                }
                $property->setValue($arrayOfPropertiesAndValues[$action_name]);
                $this->thingRepository->save($thing);
                return true;
            }
        }
        
        throw new \Exception("Non-existing Action to update");
    }
}