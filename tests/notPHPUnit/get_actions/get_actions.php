<?php
//error_reporting(E_STRICT);

error_reporting(-1);
define('ENDPOINT',getenv("IOT_EMULATOR"));
define('PORT',getenv("IOT_EMULATOR_PORT"));
define('ACTION_PREFIX','action_name');

if(!isset($argv[1])){
    die('usage: need thing id (int)'.PHP_EOL);
}

$id = $argv[1];

function sendCurl($id){
    $time = time();


    $ch = curl_init(ENDPOINT.'/'.$id.'/actions');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_PORT , PORT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'user: user',
            'password: password'
        )
    );


    $result = curl_exec($ch);
    file_put_contents("/tmp/get_actions.".$time.".html", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($result, true) . PHP_EOL, FILE_APPEND);
    var_dump($result);
    return $result;
}




$jsonResultAsArray = json_decode(sendCurl($id),true);

$expectedOutput = expectedOutput($id);
//var_dump($expectedOutput);
//var_dump($jsonResultAsArray);


if($jsonResultAsArray !== $expectedOutput){
    print 'ERROR!'.PHP_EOL;
}
else{
    print 'TEST OK'.PHP_EOL;
}

function expectedOutput($id){
    // building action
    $expectedActionId = expectedActionIdStartingPoint($id);
    $expectedDataStructure=[];
    for($i=0;$i<$id;$i++){

        $actionIncremental = $i+1;
        $expectedDataStructure[$i]['id'] = (int) $expectedActionId;
        $expectedDataStructure[$i]['name'] = ACTION_PREFIX.$actionIncremental;
        $expectedActionId++;
    }
    return $expectedDataStructure;
}

function expectedActionIdStartingPoint($id){
    $id--;
    $number = (($id*$id)+$id)/2;
    $number++;
    return $number;
}