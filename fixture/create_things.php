<?php
error_reporting(-1);

define('ENDPOINT','http://localhost/create');
define('ACTION_PREFIX','hardCodedAction');
define('PROPERTY_PREFIX','hardCodedProperty');

// TODO: mirar esto para evitar tanto 'handshake'
// http://php.net/curl_multi_init

function sendCurl($create_thing_payload){
    $time = time();

//    var_dump($create_thing_payload);

    $data_string = json_encode($create_thing_payload);

    $ch = curl_init(ENDPOINT);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_PORT , 8000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string),
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
        'name' => 'curlName'.$i,
        'brand' => 'curlBrand'.$i,

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