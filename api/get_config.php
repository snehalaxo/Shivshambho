<?php
include "../connection/config.php";
extract($_REQUEST);

$gatConfig = query("select * from settings");

while($g = fetch($gatConfig)){
    $data['data'][] = $g;
}


if(isset($mobile)){
  $data['msgs'] = rows(query("select sn from admin_chats where seen='0' AND msg_to='$mobile'"));
}





echo json_encode($data);