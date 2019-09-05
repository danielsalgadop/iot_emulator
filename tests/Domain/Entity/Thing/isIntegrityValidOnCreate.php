<?php
// TODO: use phpunit dataproviders


namespace App\Tests\Domain\Entity\Thing;


use App\Domain\Entity\Thing;
use PHPUnit\Framework\TestCase;

class isIntegrityValidOnCreate extends TestCase
{
    public function testValidSerializedThingShouldReturnTrue()
    {
        foreach ($this->myArrayOfValidThingAsArrayProvider() as $validThingAsArray) {
            $this->assertTrue(Thing::isIntegrityValidOnCreate($validThingAsArray));
        }
    }

    public function testInvalidSerializedThingShouldReturnFalse()
    {
//        $invalidArrayOfArrays
        foreach ($this->myArrayOfInvalidThingAsArrayProvider() as $invalidThingAsArray) {
            $this->assertFalse(Thing::isIntegrityValidOnCreate($invalidThingAsArray));
        }
    }


    public function myArrayOfValidThingAsArrayProvider()
    {
        return [
            [ // simplest valid
                'name' => 'thingName',
                'brand' => 'thingBrand',
                'links' =>
                    [
                        'properties' => [],
                        'actions' => [],
                    ],
            ],
            [ // 1 property and 1 action
                'name' => 'thingName',
                'brand' => 'thingBrand',
                'links' =>
                    [
                        'properties' =>
                            [
                                [
                                    'action_name1' => 'property_value1',
                                ]
                            ],
                        'actions' =>
                            [
                                'action_name1',
                            ],
                    ],
            ],
            [ // 2 properties and 2 actions
                'name' => 'thingName',
                'brand' => 'thingBrand',
                'links' =>
                    [
                        'properties' =>
                            [
                                [
                                    'action_name1' => 'property_value1',
                                    'action_name2' => 'property_value2',
                                ]
                            ],
                        'actions' =>
                            [
                                'action_name1',
                                'action_name2',
                            ],
                    ],
            ],
            [ // 2 properties and 2 actions && extra keys
                'name' => 'thingName',
                'brand' => 'thingBrand',
                'extrakey' => 'extrakeyValue',
                'links' =>
                    [
                        'properties' =>
                            [
                                [
                                    'action_name1' => 'property_value1',
                                    'action_name2' => 'property_value2',
                                ]
                            ],
                        'actions' =>
                            [
                                'action_name1',
                                'action_name2',
                            ],
                    ],
            ]
        ];
    }

    public function myArrayOfInvalidThingAsArrayProvider()
    {
        return [
            [], // emtpy array
            [   // only brand
                'brand' => 'brandValue',
            ],
            [   // only name
                'name' => 'nameValue',
            ],
            [ // links is not an array
                'brand' => 'brandValue',
                'name' => 'nameValue',
                'links' => '',
            ],
            [ // links is an empty array
                'brand' => 'brandValue',
                'name' => 'nameValue',
                'links' => [],
            ],
            [ // links['properties] is not an array
                'brand' => 'brandValue',
                'name' => 'nameValue',
                'links' => [
                    'properties' => '',
                ],
            ],
            [ // links['action] is not an array
                'brand' => 'brandValue',
                'name' => 'nameValue',
                'links' => [
                    'properties' => [],
                    'actions' => '',
                ],
            ],
            [ // Brand is null
                'brand' => null,
                'name' => 'nameValue',
                'links' => [
                    'properties' => [],
                    'actions' => [],
                ],
            ],
            [ // Brand is empty
                'brand' => '    ',
                'name' => 'nameValue',
                'links' => [
                    'properties' => [],
                    'actions' => [],
                ],
            ],
            [ // Name is null
                'brand' => 'brandValue',
                'name' => null,
                'links' => [
                    'properties' => [],
                    'actions' => [],
                ],
            ],
            [ // Name is empty
                'brand' => 'brandValue',
                'name' => '    ',
                'links' => [
                    'properties' => [],
                    'actions' => [],
                ],
            ]
        ];
    }
}
