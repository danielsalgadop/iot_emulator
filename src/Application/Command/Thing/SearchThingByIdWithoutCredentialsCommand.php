<?php

namespace App\Application\Command\Thing;

class SearchThingByIdWithoutCredentialsCommand
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
