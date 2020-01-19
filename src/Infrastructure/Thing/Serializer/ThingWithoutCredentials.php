<?php


namespace App\Infrastructure\Thing\Serializer;

use App\Domain\Entity\Thing;

class ThingWithoutCredentials
{
    public static function asObject(Thing $thing): \stdClass
    {
        $obj = new \stdClass();

        $obj->id = $thing->getId();
        $obj->name = $thing->getName();
        $obj->brand = $thing->getBrand();
        return $obj;
    }
}
