<?php
include "../connection/config.php";
extract($_REQUEST);

if(isset($_REQUEST['date'])){
   
$sx = query("SELECT * FROM `games` where user='$mobile' AND date='".$_REQUEST['date']."' order by created_at desc");
} else {
    
$sx = query("SELECT * FROM `games` where user='$mobile' order by created_at desc");
}

while($x = fetch($sx))
{
    $x['date'] = date('d M Y, h:i A',$x['created_at']);
    $data['data'][] = $x;
}

if(isset($_REQUEST['date'])){
    
$sx = query("SELECT * FROM `starline_games` where user='$mobile' AND date='".$_REQUEST['date']."' order by created_at desc");
} else {
    
$sx = query("SELECT * FROM `starline_games` where user='$mobile' order by created_at desc");
}

while($x = fetch($sx))
{
    $x['bazar'] = $x['bazar']." ".$x['timing_sn'];
    $x['date'] = date('d M Y, h:i A',$x['created_at']);
    $data['data'][] = $x;
}

function date_compare($a, $b)
{
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    $r = $t1 - $t2;
  if($r < 0){ return 1; } else {
     return -1;
  }
}    
usort($data['data'], 'date_compare');

echo json_encode($data);