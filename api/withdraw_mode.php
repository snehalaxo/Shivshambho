<?php
include "../connection/config.php";
extract($_REQUEST);

if(rows(query("select sn from withdraw_details where user='$mobile'")) == 0){
    
    query("INSERT INTO `withdraw_details`(`user`, `prefered`, `upi`, `acno`, `name`, `ifsc`,`bank`,`paytm`,`phonepe`,`gpay`) VALUES ('$mobile','','','$acno','$name','$ifsc','$bank','$paytm','$phonepe','$gpay')");

} else if($mode == "bank") {
    
    query("update withdraw_details set acno='$acno', name='$name', ifsc='$ifsc', bank='bank' where user='$mobile'");
    
} else if($mode == "gpay") {
    
    query("update withdraw_details set gpay='$gpay' where user='$mobile'");
    
} else if($mode == "phonepe") {
    
    query("update withdraw_details set phonepe='$phonepe' where user='$mobile'");
    
    
} else if($mode == "paytm") {
    
    query("update withdraw_details set paytm='$paytm' where user='$mobile'");
    
}

$data['success'] = "1";
$data['msg'] = "Withdraw details updated";

echo json_encode($data);