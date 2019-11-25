<?php
error_reporting(-1);

define('ENDPOINT',getenv("IOT_EMULATOR"));
define('PORT',getenv("IOT_EMULATOR_PORT"));
//define('PORT',8000);
define('ACTION_PREFIX','action_name');
define('PROPERTY_PREFIX','property_value');

// TODO: mirar esto para evitar tanto 'handshake'
// http://php.net/curl_multi_init

function sendCurl($createThingPayload){
    $time = time();

//    var_dump($createThingPayload);

    $dataString = json_encode($createThingPayload);
    print_r($dataString);

    $ch = curl_init(ENDPOINT.'/create');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_PORT , PORT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataString),
            'user: user',
            'password: password'
        )
    );


    $result = curl_exec($ch);
    file_put_contents("/tmp/debug.".$time.".html", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($result, true) . PHP_EOL, FILE_APPEND);
    var_dump($result);
}


// create things loop

for($i=1;$i<5;$i++){



    $data = array(
        'name' => 'thing_name'.$i,
        'brand' => 'thing_brand'.$i,

    );

    $data['links'] = buildPropertiesAndActions($i);
    sendCurl($data);
}

function buildPropertiesAndActions(int $i):array{
    $array['actions'] = buildActions($i);
    $array['properties'] = buildProperties($i);
    return $array;
}

function buildProperties(int $i): array{
    $properties = [];
    for($j=1;$j<=$i;$j++){
        $properties[]=[ACTION_PREFIX.$j => PROPERTY_PREFIX.$j];
    }
    return $properties;
}

function buildActions(int $i): array{
    $actions = [];
    for($j=1;$j<=$i;$j++) {
        $actions[]=ACTION_PREFIX.$j;
    }
    return $actions;
}