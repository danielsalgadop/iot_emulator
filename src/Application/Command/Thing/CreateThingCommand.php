<?php

namespace App\Application\Command\Thing;
use App\Domain\Dto\UserCredentialsDTO;

class CreateThingCommand
{
    private $array;
    private $userCredentialsDTO;

    public function __construct(array $array, UserCredentialsDTO $userCredentialsDTO)
    {
        $this->array = $array;
        $this->userCredentialsDTO = $userCredentialsDTO;
    }

    // Definition of iot
    public function getArray()
    {
        return $this->array;
    }
    /**
     * @return string
     */
    public function getUserDTO(): UserCredentialsDTO
    {
        return $this->userCredentialsDTO;
    }

    // DUDA
    /*
     * Enmascarar los getters para usar el UserDTO dentro de este CreateThingCommand, ¿tiene sentido?
     * La otra opcion es donde se necesite (en Entity/Thing.php, en este caso) hace $userDto = $command->getUserDTO para
     * obterner $userName = $userDto->getUser
     */
      public function getUserName(){
       return $this->userCredentialsDTO->getUser;
      }

      public function getPassword(){
       return $this->userCredentialsDTO->getPassword;
      }



}