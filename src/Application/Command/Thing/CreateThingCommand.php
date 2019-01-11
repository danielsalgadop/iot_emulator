<?php

namespace App\Application\Command\Thing;


class CreateThingCommand
{
    private $json;
    private $user;
    private $password;

    public function __construct($json, string $user, string $password)
    {
        $this->json     = $json;
        $this->user     = $user;
        $this->password = $password;
    }

    public function getJson()
    {
        return $this->json;
    }
    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


}