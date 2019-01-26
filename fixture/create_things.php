<?php
error_reporting(-1);

define('ENDPOINT','http://localhost/create');


// TODO: mirar esto para evitar tanto 'handshake'
// http://php.net/curl_multi_init

function sendCurl(){
    $time = time();


    $data = array(
    'name' => 'curlName',
    'brand' => 'curlBrand',
    'links' =>
        array (
            'properties' =>
                array (
                    0 =>
                        array (
                            'curlAction1' => 'curlActionValue1',
                        ),
                    1 =>
                        array (
                            'curlAction2' => 'curlActionValue2',
                        ),
                ),
            'actions' =>
                array (
                    0 => 'curlAction1',
                    1 => 'curlAction2',
                ),
        ),
);
    $data_string = json_encode($data);

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


sendCurl();