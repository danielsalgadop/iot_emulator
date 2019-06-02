<?php


namespace App\Infrastructure\Thing\Serializer;

use App\Domain\Entity\Thing;

class ThingWithCredentials
{
    public static function asObject(Thing $thing): \stdClass
    {
        $obj = new \stdClass();
        $obj->id = $thing->getId();
        $obj->name = $thing->getName();
        $obj->brand = $thing->getBrand();
        $obj->links = ThingActions::asObject($thing);
        return $obj;
    }
}