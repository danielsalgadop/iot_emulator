<?php

namespace App\Application\Command\Thing;

use App\Application\Dto\UserCredentialsDTO;

class SearchThingByIdCommand
{
    private $id;
    private $userCredentialsDTO;

    public function __construct(int $id, UserCredentialsDTO $userCredentialsDTO)
    {
        $this->id = $id;
        $this->userCredentialsDTO = $userCredentialsDTO;
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
        return $this->userCredentialsDTO->getName();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->userCredentialsDTO->getPassword();
    }
}
