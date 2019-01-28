<?php


namespace App\Infrastructure\Thing\Serializer;
use App\Domain\Entity\Thing;

class ThingActions
{
    public static function asJson(Thing $thing)
    {
        $obj = ThingWithoutCredentials::asObject($thing);
        $obj = Thing::publicInfoAsObject($thing);
        $actions = $thing->getActions();
        $obj->actions['link'] = "/actions";
        foreach ($actions as $action){
            $property = $action->getProperty();
            $obj->actions['resources'][$action->getName()]['values'] = $property->getValue();
        }
        return json_encode($obj);
    }
}