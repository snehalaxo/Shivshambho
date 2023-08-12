<?php
include "../connection/config.php";
extract($_REQUEST);

$check = query("select mobile,email from users where mobile='$mobile'");

if(rows($check) > 0)
{
    $data['success'] = "0";
    $data['msg'] = "Mobile number already registered";
}
else
{
    $data['success'] = "1";
    $data['msg'] = "Register successfull";
    
    $code = substr($mobile,0,2).rand(100000,9999999);
  
  if(rows(query("select data from settings where data_key='auto_verify' AND data='1'")) > 0) {
   	$verify = "1"; 
  } else {
	$verify = "0"; 
  }
  
  $get_reward = fetch(query("select data from settings where data_key='signup_reward'"));
    
    query("INSERT INTO `users`( `name`, `email`, `mobile`,  `password`, `created_at`, `code`,`verify`,`wallet`,`session`) VALUES ('$name','$email','$mobile','$pass','$stamp', '$code','$verify','".$get_reward['data']."','$session')");
    
    if($refcode != '')
    {
        query("INSERT INTO `refers`( `user`, `code`) VALUES ('$mobile','$refcode') ");
    }
}

echo json_encode($data);
