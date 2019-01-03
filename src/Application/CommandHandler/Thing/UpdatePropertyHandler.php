<?php

namespace App\Application\CommandHandler\Thing;


use App\Application\Command\Thing\UpdatePropertyCommand;
//use App\Domain\Entity\Action;
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
        $objData = Thing::decodeJsonToObjectOrException($command->getJsonOfPropertiesAndValues());
        // remove action

        // create action



        file_put_contents("/tmp/debug.txt", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($objData, true) . PHP_EOL, FILE_APPEND);
//        $objData = Thing::validJson();
//        file_put_contents("/tmp/debug.txt", var_export($properties, true) . PHP_EOL, FILE_APPEND);



//        $thing = new Thing($objData->name,$objData->brand,$actionCollector);
//        $this->thingRepository->save($thing);
//        return $thing;
    }
}