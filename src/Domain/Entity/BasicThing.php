<?php


namespace App\Domain\Entity;


class BasicThing
{

    public function __construct($objData)
    {
        if(!isset($objData->brand)){
            throw new \Exception("No Brand found");
        }
        if(!isset($objData->name)){
            throw new \Exception("No Name found");
        }
    }
}