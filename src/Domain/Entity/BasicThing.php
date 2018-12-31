<?php


namespace App\Domain\Entity;


class BasicThing
{

    public function __construct($objData)
    {
        if(!isset($objData->brand)){
            throw new \Exception("No Brand found");
        }
    }
}