<?php
include "../connection/config.php";
extract($_REQUEST);

$dd = query("select session,active from users where mobile='$mobile'");
$d = fetch($dd);
if($d['session'] != $_REQUEST['session']){
    $data['success'] = "0";
    $data['msg'] = "You are not authorized to use this";
    $data['session0'] = $d['session'];
    $data['session1'] = $_REQUEST['session'];

    echo json_encode($data);
    return;
}

$order_id = md5($mobile.$amount.$d['session']);

$hash = openssl_encrypt($order_id, "AES-128-ECB", $_REQUEST['hash_key']);

$data['hash0'] = $hash;


$hash = openssl_encrypt($order_id, "AES-128-ECB", $_REQUEST['hash_key']);

$data['hash2'] = $hash;


$gateway = query("INSERT INTO `gateway_temp`( `user`, `amount`, `hash`, `type`) VALUES ('$mobile','$amount','$hash','$type')");

$data['success'] = "1";
$data['hash'] = $order_id;

echo json_encode($data);