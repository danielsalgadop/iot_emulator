<?php


namespace App\Tests\notPHPUnit;
require('../../vendor/autoload.php');

use App\Domain\Entity\Thing;
use App\Domain\Entity\User;
use App\Application\Dto\UserCredentialsDTO;

$name = "name_mock";
$brand = "brand_mock";
$actionCollector = [];

$userCredentialsDTO = new UserCredentialsDTO('user','password');

$user = new User();
$user->setName($userCredentialsDTO->getName());
$user->setPassword($userCredentialsDTO->getPassword());


$thing = new Thing($name, $brand, $actionCollector, $user);

var_dump($thing);
