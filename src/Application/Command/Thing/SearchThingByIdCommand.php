<?php

namespace App\Application\Command\Thing;


class SearchThingByIdCommand
{
    private $id;
    private $user;
    private $password;

    public function __construct(int $id, string $user, string $password)
    {
        $this->id = $id;
        $this->user = $user;
        $this->password = $password;
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
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}