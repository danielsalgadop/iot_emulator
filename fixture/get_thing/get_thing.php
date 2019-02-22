<?php
//error_reporting(E_STRICT);
error_reporting(-1);

define('ENDPOINT','http://localhost');
define('ACTION_PREFIX','action_name');

if(!isset($argv[1])){
    die('usage: need thing id (int)'.PHP_EOL);
}

$id = $argv[1];

function sendCurl($id){
    $time = time();


    $ch = curl_init(ENDPOINT.'/'.$id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_PORT , 8001);
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




$json_result_as_array = json_decode(sendCurl($id),true);

$expected_output = expectedOutput($id);
//var_dump($expected_output);
//var_dump($json_result_as_array);


if($json_result_as_array !== $expected_output){
    print 'ERROR!'.PHP_EOL;
}
else{
    print 'TEST OK'.PHP_EOL;
}

function expectedOutput($id){
    // building action
    $expected_action_id = expectedActionIdStartingPoint($id);
    $expected_data_structure=[];
    for($i=0;$i<$id;$i++){

        $action_incremental = $i+1;
        $expected_data_structure[$i]['id'] = (int) $expected_action_id;
        $expected_data_structure[$i]['name'] = ACTION_PREFIX.$action_incremental;
        $expected_action_id++;
    }
    return $expected_data_structure;
}

function expectedActionIdStartingPoint($id){
    $id--;
    $number = (($id*$id)+$id)/2;
    $number++;
    return $number;
}