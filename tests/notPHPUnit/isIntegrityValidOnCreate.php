<?php
// DEPRECATED. this test is now donw in test/isIntegrityValidOnCreate.php

namespace App\Tests\notPHPUnit;
require('../../vendor/autoload.php');

use App\Domain\Entity\Thing;
use App\Domain\Entity\User;
use App\Application\Dto\UserCredentialsDTO;

//$name = "name_mock";
//$brand = "brand_mock";
//$actionCollector = [];
//
//$userCredentialsDTO = new UserCredentialsDTO('user','password');
//
//$user = new User();
//$user->setName($userCredentialsDTO->getName());
//$user->setPassword($userCredentialsDTO->getPassword());
//
//
//$thing = new Thing($name, $brand, $actionCollector, $user);
//
//
//var_dump($thing);


$validArrayOfArraysDataForThings = [
    [
        'brand' => 'brandValue',
        'name' => 'nameValue',
        'actions' => 'actionsValue',
        'properties' => 'PropertiesValue',
    ],
    [
        'brand' => 'brandValue2',
        'name' => 'nameValue2',
        'actions' => 'actionsValue2',
        'properties' => 'PropertiesValue2',
    ],
];

foreach ($validArrayOfArraysDataForThings as $validArrayOfArraysDataForThing) {
    $data['brand'] = $validArrayOfArraysDataForThing['brand'];
    $data['name'] = $validArrayOfArraysDataForThing['name'];
    $data['links']['actions'] = $validArrayOfArraysDataForThing['actions'];
    $data['links']['properties'] = $validArrayOfArraysDataForThing['properties'];
    var_dump($data);
    if (Thing::isIntegrityValidOnCreate($data) !== true) {

        print "something Wrong!";
    }
}



