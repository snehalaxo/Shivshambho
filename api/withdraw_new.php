<?php
include "../connection/config.php";
extract($_REQUEST);

if(rows(query("select sn from users where mobile='$mobile' and session ='$session'")) == 0){
    $data['msg'] = "You are not authrized to use this";
   
    $data['active'] = "0";
    
    echo json_encode($data);
    return;
} else {
          
    $dd = query("select active from users where mobile='$mobile'");
    $d = fetch($dd);
    $data['active'] = "1";
}

$get_times = query("select * from settings where data_key='withdrawOpenTime' OR data_key='withdrawCloseTime'");
while($get = fetch($get_times)){
    $times[$get['data_key']] = $get['data'];
}


$current_time = date('H:i:s Y-m-d');
$sunrise = $times['withdrawOpenTime'].":00 ".date('Y-m-d');
$sunset = $times['withdrawCloseTime'].":00 ".date('Y-m-d');
$date1 = strtotime($current_time);
$date2 = strtotime($sunrise);
$date3 = strtotime($sunset);
if ($date1 > $date2 && $date1 < $date3)
{
  
$check = query("select wallet from users where mobile='$mobile' AND wallet >= $amount");

if(rows($check) > 0){
    
    if($mode == "paytm"){
        
        if(rows(query("select sn from withdraw_details where user='$mobile' AND paytm=''")) > 0){
               $data['msg'] = "PayTM withdraw information not updated, please update details or select other withdraw mode";
                $data['success'] = "2";
                echo json_encode($data);
                return;
        }
        
    } else if($mode == "phonepe"){
        
        if(rows(query("select sn from withdraw_details where user='$mobile' AND phonepe=''")) > 0){
               $data['msg'] = "PhonePe withdraw information not updated, please update details or select other withdraw mode";
                $data['success'] = "2";
                echo json_encode($data);
                return;
        }
        
    } else if($mode == "gpay"){
        
        if(rows(query("select sn from withdraw_details where user='$mobile' AND gpay=''")) > 0){
               $data['msg'] = "GooglePay withdraw information not updated, please update details or select other withdraw mode";
                $data['success'] = "2";
                echo json_encode($data);
                return;
        }
        
    } else if($mode == "bank"){
        
        if(rows(query("select sn from withdraw_details where user='$mobile' AND ( acno='' || name='' || ifsc='' || bank='' )")) > 0){
               $data['msg'] = "Bank withdraw information not updated, please update details or select other withdraw mode";
                $data['success'] = "2";
                echo json_encode($data);
                return;
        }
        
    }

    query("INSERT INTO `withdraw_requests`( `user`, `amount`, `mode`, `info`, `status`, `created_at`, `paytm`, `phonepe`, `ac`, `ifsc`, `holder`) VALUES ('$mobile','$amount','$mode','','0','$stamp', '','','','','')");
    
    query("UPDATE users set wallet=wallet-$amount where mobile='$mobile'");
    
    query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES ('$mobile','$amount','0','Withdraw to Bank','user','$stamp','0','0')");
    
    $get_bal = fetch(query("select wallet from users where mobile='$mobile'"));
    
    $data['wallet'] = $get_bal['wallet'];
    
    $data['msg'] = "Your withdraw request received by our team";
   
    $data['success'] = "1";

} else {
    
    $data['msg'] = "You don't have enough wallet balance";
   
    $data['success'] = "0";
    
}

  
} else {
       $data['msg'] = "Withdraw only allowed between ".date('h:i A',$date2)." to ".date('h:i A',$date3);
   
    $data['success'] = "0";
    
    echo json_encode($data);
  return;
  
}

echo json_encode($data);