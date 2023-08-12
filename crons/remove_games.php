<?php
include "../connection/config.php";
extract($_REQUEST);

$date = strtotime('-30 days');

$get_data = query("select * from games where created_at < $date");

while($data = fetch($get_data)){
 
  $sn = $data['sn'];
  
  query("INSERT INTO `games_archive`(`sn`,`user`, `game`, `bazar`, `date`, `number`, `amount`, `status`, `created_at`, `is_loss`) 
  VALUES ('".$data['sn']."','".$data['user']."','".$data['game']."','".$data['bazar']."','".$data['date']."','".$data['number']."','".$data['amount']."','".$data['status']."','".$data['created_at']."','".$data['is_loss']."')");
  
  
  query("delete from games where sn='$sn'");
  
  
}


$get_data = query("select * from transactions where created_at < $date");

while($data = fetch($get_data)){
 
  $sn = $data['sn'];
  
  query("INSERT INTO `transactions_archive`(`sn`, `user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES 
  ('".$data['sn']."','".$data['user']."','".$data['amount']."','".$data['type']."','".$data['remark']."','".$data['owner']."','".$data['created_at']."','".$data['game_id']."','".$data['batch_id']."')");
  
 
  query("delete from transactions where sn='$sn'");
  
  
}