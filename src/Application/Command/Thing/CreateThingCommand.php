<?php

namespace App\Application\Command\Thing;


class CreateThingCommand
{
    private $json;
    private $action;

    public function __construct($json,$action)
    {
        $this->json = $json;
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }
    public function getJson()
    {
        return $this->json;
    }
}