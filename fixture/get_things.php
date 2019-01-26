<?php
//error_reporting(E_STRICT);
error_reporting(-1);

define('ENDPOINT','http://localhost');

function sendCurl(){
    $time = time();


    $ch = curl_init(ENDPOINT);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_PORT , 8000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    file_put_contents("/tmp/debug.".$time.".html", __METHOD__ . ' ' . __LINE__ . PHP_EOL . var_export($result, true) . PHP_EOL, FILE_APPEND);
    var_dump($result);
}


sendCurl();