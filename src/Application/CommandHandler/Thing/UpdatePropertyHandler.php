<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\UpdatePropertyCommand;
//use App\Domain\Entity\Action;
use App\Domain\Entity\Action;
use App\Domain\Entity\Property;
use App\Domain\Entity\Thing;
//use App\Domain\Entity\Property;
use App\Domain\Repository\ThingRepository;

class UpdatePropertyHandler
{

    public function __construct(ThingRepository $thingRepository)
    {
        $this->thingRepository = $thingRepository;
    }

    public function handle(UpdatePropertyCommand $command)
    {
        // esta decodificacion de json -> array debería estar en ThingController ( y lo mismo pasa con create/)
        $thing = $command->getThing();

        // Check if action exists and remove it if it does. Or exception if it does not
        $actualActions = $thing->getActions();

        $flag_action_exists = false;
        foreach ($actualActions as $action){
            // We are assuming 1 action has 1 property, that is why we remove whole action.
            if($action->getName() === $command->getAction()){
                $thing->removeAction($action);
                $flag_action_exists = true;
            }
//            file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($action->getName(), true) . PHP_EOL, FILE_APPEND);
        }
        if($flag_action_exists === false){
            throw new \Exception("Non-existing Action for update");
        }

//        file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export(\Doctrine\Common\Util\Debug::dump($actualActions, 4), true) . PHP_EOL, FILE_APPEND);
//        $thing->removeAction($command->getAction());

        $arrayOfPropertiesAndValues = Thing::decodeJsonToObjectOrException($command->getJsonOfPropertiesAndValues());
        // Again, we assume that 1 action has only 1 property. This foreach could be
        file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($arrayOfPropertiesAndValues, true) . PHP_EOL, FILE_APPEND);
        foreach ($arrayOfPropertiesAndValues as $propertyName => $propertyValue){
            $action = new Action();
            $property = new Property();
            $property->setValue($propertyValue);
            $action->setProperty($property);
            $action->setName($command->getAction());
        }
        $thing->addAction($action);
        $this->thingRepository->save($thing);
//






        // create action
//        $action = new Action();
//        $property = new Property();

//        $arrayOfPropertiesAndValues = Thing::validJson();
//        file_put_contents("/tmp/debug.txt", var_export($properties, true) . PHP_EOL, FILE_APPEND);



//        $thing = new Thing($arrayOfPropertiesAndValues->name,$arrayOfPropertiesAndValues->brand,$actionCollector);
//        $this->thingRepository->save($thing);
//        return $thing;
    }
}