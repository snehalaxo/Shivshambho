<?php
include "../connection/config.php";
extract($_REQUEST);

if(rows(query("select sn from withdraw_details where user='$mobile'")) == 0){
    
    
$data['success'] = "0";
} else {
    
    $data = fetch(query("select * from withdraw_details where user='$mobile'"));
    
$data['success'] = "1";
}

echo json_encode($data);