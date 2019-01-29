<?php


namespace App\Infrastructure\Thing\Serializer;
use App\Domain\Entity\Thing;

class ThingActions
{
    public static function asJson(Thing $thing)
    {
        return json_encode(self::asObject($thing));
    }

    public static function asObject(Thing $thing)
    {
        $actions = $thing->getActions();
        $obj->actions['link'] = "/actions";
        foreach ($actions as $action){
            $property = $action->getProperty();
            $obj->actions['resources'][$action->getName()]['values'] = $property->getValue();
        }
        return $obj;
    }
}