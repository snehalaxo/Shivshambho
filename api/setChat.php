<?php
include "../connection/config.php";
extract($_REQUEST);

query("update admin_chats set seen='1' where user='$mobile' OR msg_to='$mobile'");

query("INSERT INTO `admin_chats`(`user`, `message`, `seen`, `msg_to`, `created_at`) VALUES ('$mobile','$message','0','admin','$stamp')");

$gateway = query("select * from admin_chats where user='$mobile' OR msg_to='$mobile'");

while($g = fetch($gateway)){
  $g['time'] = date('h:i A d/m/y', $g['created_at']);
    $data['data'][] = $g;
}

echo json_encode($data);