<?php

namespace App\Application\Command\Thing;


class UpdatePropertyCommand
{
    // DUDA, se podria sacar todo del request, y no enviar ni $id, ni $action
    private $id;
    private $action;
    private $arrayOfProperties;

    public function getId()
    {
        return $this->id;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getArrayOfProperties()
    {
        return $this->arrayOfProperties;
    }

    public function __construct($id,$action,$arrayOfProperties)
    {
        $this->id = $id;
        $this->action = $action;
        $this->arrayOfProperties = $arrayOfProperties;
    }

}