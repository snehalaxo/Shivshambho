<?php
include "../connection/config.php";
extract($_REQUEST);

$sx = query("SELECT * FROM `withdraw_requests` where user='$mobile' order by created_at desc");
while($x = fetch($sx))
{
    
    if($x['status'] == "0"){
        $x['status'] = "Pending";
    } else if($x['status'] == "1"){
        $x['status'] = "Completed";
    } else {
        $x['status'] = "Rejected";
    }
    
    if($x['mode'] == "Phonepe"){
        $x['details'] = $x['phonepe'];
    } else if($x['mode'] == "Paytm"){
        $x['details'] = $x['paytm'];
    } else if($x['mode'] == "Bank"){
        $details = "AC - ".$x['ac'];
        $x['details'] = $details;
    }
    
    $x['date'] = date('d/m/y',$x['created_at']);
    $data['data'][] = $x;
}

echo json_encode($data);