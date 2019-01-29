<?php


namespace App\Infrastructure\Thing\Serializer;
use App\Domain\Entity\Thing;
use App\Infrastructure\Thing\Serializer\ThingWithoutCredentials;
use App\Infrastructure\Thing\Serializer\ThingActions;

class ThingWithCredentials
{
    public static function asObject(Thing $thing): \stdClass {
        $obj = new \stdClass();
        $obj->id = $thing->getId();
        $obj->name = $thing->getName();
        $obj->brand = $thing->getBrand();
        $obj->actions = ThingActions::asObject($thing);
        return $obj;
    }
}