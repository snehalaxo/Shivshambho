<?php
date_default_timezone_set("Asia/Kolkata");


$servername = "localhost";
$username = "shivshambho_matka_app";
$password = "Ik6pkHJ@B9*8";
$dbname = "shivshambho_matka_app";

// Create connection
$con = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";


function sendNotification($body,$title,$topic){
    $msg = array
    (
        'body'  => $body,
        'title'     => $title,
        'vibrate'   => 1,
        'sound'     => 1,
    );
    
    $data['body'] = $body;
    $data['title'] = $title;
    
    $fields = array
    (
        'to'  => '/topics/'.$topic,
        'notification'  => $msg,
        'data' => $data
    );
    
    $headers = array
    (
        'Authorization: key=AAAAC3HFcJA:APA91bFj8a7_ZRcvZPq21brX7dlqhWV92CiD2jrqJZRqdCK4L7RZoIanRM_Gpw_f_DzH0tFK4Awph2lsKiNXLTiKU9FFMMk5hLRFhPAGhpqP7K9nadkrO79COvgW1MIPGsHIZTSHCwo4',
        'Content-Type: application/json'
    );
    
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    curl_close( $ch );
}


function getRate($market,$game){


  $servername = "localhost";
$username = "shivshambho_matka_app";
$password = "Ik6pkHJ@B9*8";
$dbname = "shivshambho_matka_app";

  // Create connection
  $con = mysqli_connect($servername, $username, $password,$dbname);

  $check_man = mysqli_query($con,"select rate from market_rates where market='$market' AND game='$game'");
  if(mysqli_num_rows($check_man)>0){
   $get_man = mysqli_fetch_array($check_man); 
    return $get_man['rate'];
  } else {
    $get_rate = mysqli_fetch_array(mysqli_query($con,"select * from rate"));
    return $get_rate[$game];
  }
}
?>