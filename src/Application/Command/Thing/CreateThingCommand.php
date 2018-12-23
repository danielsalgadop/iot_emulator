<?php

namespace App\Application\Command\Thing;


class CreateThingCommand
{
    private $json;
    private $actions;

    public function __construct($json,$actions)
    {
        $this->json = $json;
        $this->actions = $actions;
    }

    public function getActions()
    {
        return $this->actions;
    }
    public function getJson()
    {
        return $this->json;
    }
}