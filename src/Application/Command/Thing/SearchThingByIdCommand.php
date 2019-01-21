<?php

namespace App\Application\Command\Thing;


use App\Domain\Dto\UserCredentialsDTO;

class SearchThingByIdCommand
{
    private $id;
    private $UserCredentialsDTO;

    public function __construct(int $id, UserCredentialsDTO $UserCredentialsDTO)
    {
        $this->id = $id;
        $this->UserCredentialsDTO = $UserCredentialsDTO;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
    * @return mixed
    */
    public function getUser()
    {
        return $this->UserCredentialsDTO->getName();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->UserCredentialsDTO->getPassword();
    }
}