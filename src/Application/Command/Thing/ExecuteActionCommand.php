<?php

namespace App\Application\Command\Thing;

use App\Domain\Entity\Thing;

class ExecuteActionCommand
{
    // DUDA, se podria sacar todo del request, y no enviar ni $id, ni $action
    private $thing;
    private $action;
    private $arrayPropertyAndValue;

    /**
     * @return Thing
     */
    public function getThing(): Thing
    {
        return $this->thing;
    }

    public function getArrayOfPropertyNameAndValue(): array
    {
        return $this->arrayPropertyAndValue;
    }


    public function getAction()
    {
        return $this->action;
    }

    public function __construct(Thing $thing, string $action, array $arrayPropertyAndValue)
    {
        $this->thing = $thing;
        $this->action = $action;
        $this->arrayPropertyAndValue = $arrayPropertyAndValue;
    }

}