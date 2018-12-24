<?php

namespace App\Application\Command\Thing;


class CreateThingCommand
{
    private $json;

    public function __construct($json)
    {
        $this->json = $json;
    }

    public function getJson()
    {
        return $this->json;
    }
}