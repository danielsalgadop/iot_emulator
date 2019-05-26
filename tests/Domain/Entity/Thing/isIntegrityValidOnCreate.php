<?php

namespace App\Tests\Domain\Entity\Thing;


use PHPUnit\Framework\TestCase;
use App\Domain\Entity\Thing;

class isIntegrityValidOnCreate extends TestCase
{
    /**
     * @dataProvider validSerializedThingsProvider
     */
    public function testValidSerializedThingShoudReturnTrue($validSerializedThing)
    {
        $this->assertTrue(Thing::isIntegrityValidOnCreate($validSerializedThing));
    }

    /**
     * @dataProvider invalidSerializedThingsProvider
     */
    /*public function testInvalidSerializedThingShouldReturnFalse($nullNameNullBrandNllLinksSerializedThing)
    {
//        var_dump($nullNameNullBrandNllLinksSerializedThing);
        $this->assertFalse(Thing::isIntegrityValidOnCreate($nullNameNullBrandNllLinksSerializedThing));
    }*/

    public function validSerializedThingsProvider()
    {
        return
            [
                'one' =>
                    [
                        [
                            'brand' => 'brandValue1',
                            'name' => 'nameValue1',
                            'links' => [
                                'properties' => ['actionsValue1' => 'propertiesValue1'],
                                'actions' => 'actionsValue1',
                            ],
                        ],
                    ],
                'two' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [
                                'properties' => ['actionsValue1' => 'propertiesValue1'],
                                'actions' => 'actionsValue1',
                            ],
                        ],
                    ],
                'permisiveWithExtraKeys' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'extraKey' => 'extraKeyValue',
                            'links' => [
                                'properties' => ['actionsValue1' => 'propertiesValue1'],
                                'actions' => 'actionsValue1',
                            ],
                        ],
                    ],
            ];

    }

    public function invalidSerializedThingsProvider()
    {
        return
            [
                'nullBrand' =>
                    [
                        [
                            'brand' => null,
                            'name' => 'nameValue',
                            'links' => [
                                'properties' => 'propertiesValue',
                                'actions' => 'actionsValue',
                            ],
                        ],
                    ],
                'nullName' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => null,
                            'links' => [
                                'actions' => 'actionsValue',
                                'properties' => 'propertiesValue',
                            ],
                        ],
                    ],
                'nullLinks' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameVale',
                            'links' => null,
                        ],
                    ],
                'emptyBrand' =>
                    [
                        [
                            'brand' => '',
                            'name' => 'nameValue',
                            'links' => [
                                'actions' => 'actionsValue',
                                'properties' => 'propertiesValue',
                            ],
                        ],
                    ],
                'emptyName' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => '   ',
                            'links' => [
                                'actions' => 'actionsValue',
                                'properties' => 'propertiesValue',
                            ],
                        ],
                    ],
                'emptyLinks' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [],
                        ],
                    ],
                'notArrayLinks' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => 'notArrayLinks',
                        ],
                    ],
                'notExistingLinks_Actions' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [
                                'properties' => 'propertiesValue',
                            ],
                        ],
                    ],
                'notExistingLinks_Properties' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [
                                'actions' => 'ActionsValue',
                            ],
                        ],
                    ],
                'nullLinks_Actions' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [
                                'actions' => null,
                                'properties' => 'propertiesValue',
                            ],
                        ],
                    ],
                'nullLinks_Properties' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [
                                'actions' => 'actionsValue',
                                'properties' => null,
                            ],
                        ],
                    ],
                'emptyLinks_Actions' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [
                                'actions' => ' ',
                                'properties' => 'propertiesValue',
                            ],
                        ],
                    ],
                'emptyLinks_Properties' =>
                    [
                        [
                            'brand' => 'brandValue',
                            'name' => 'nameValue',
                            'links' => [
                                'actions' => 'actionsValue',
                                'properties' => ' ',
                            ],
                        ],
                    ],
            ];
    }
}
