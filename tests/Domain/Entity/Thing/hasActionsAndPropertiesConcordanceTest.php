<?php
// TODO: use phpunit dataproviders


namespace App\Tests\Domain\Entity\Thing;


use App\Domain\Entity\Thing;
use PHPUnit\Framework\TestCase;

class isIntegrityValidOnCreate extends TestCase
{
    public function testValidSerializedThingShouldReturnTrue()
    {
        foreach ($this->myArrayOfValidThingAsArrayProvider() as $validPropertiesAndActions) {

            $actions = $validPropertiesAndActions['actions'];
            $properties = $validPropertiesAndActions['properties'];

            $this->assertTrue(Thing::hasActionsAndPropertiesConcordance($properties, $actions));
        }
    }

    public function testInValidSerializedThingShouldReturnTrue()
    {
        foreach ($this->myArrayOfInValidThingAsArrayProvider() as $InValidPropertiesAndActions) {

            $actions = $InValidPropertiesAndActions['actions'];
            $properties = $InValidPropertiesAndActions['properties'];

            $this->assertFalse(Thing::hasActionsAndPropertiesConcordance($properties, $actions));
        }
    }

    public function myArrayOfValidThingAsArrayProvider()
    {
        return [
            [
                'properties' => [
                    [
                        'propertyName' => 'propertyValue'
                    ],
                ],
                'actions' =>
                    [
                        'propertyName',
                    ],
            ],
            [
                'properties' => [],
                'actions' => [],
            ]
        ];
    }

    public function myArrayOfInvalidThingAsArrayProvider()
    {
        return [
            [ // StrangePropertyName (in actions)
                'properties' => [

                    [
                        'propertyName' => 'propertyValue'
                    ],
                ],
                'actions' =>
                    [
                        'StrangePropertyName',
                    ],
            ],
            [ // StrangePropertyName (in properties)
                'properties' => [

                    [
                        'StrangePropertyName' => 'propertyValue'
                    ],
                ],
                'actions' =>
                    [
                        'propertyName',
                    ],
            ]


        ];
    }
}
