<?php

namespace App\Aplication\Command\Thing;


class CreateThingCommand
{
    private $json;

    public function __construct($json)
    {
        $this->json = $json;
    }
}