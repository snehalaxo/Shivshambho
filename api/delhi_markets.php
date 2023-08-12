<?php
include "../connection/config.php";
extract($_REQUEST);

$time = date("H:i",$stamp);
$day = strtoupper(date("l",$stamp));
$date = date("d/m/Y");


$sx = query("SELECT * FROM `rates` where sn='1'");
$x = fetch($sx);
$data = $x;

$get_timings = query("select * from gametime_delhi order by str_to_date(open, '%H:%i')");

while($xc = fetch($get_timings)){
    
    $market = $xc['market'];
  
    $time_id = $xc['close'];
    $dd['close'] = $time_id;
    
        $dd['days'] = $mrk['days'];
        $dd['$day'] = $day;
    if($mrk['days'] == "" || substr_count($mrk['days'],$day) == 0){
    
        if(strtotime($time)<strtotime($xc['close'])) {
            $dd['is_open'] = "1";
        } else {
            $dd['is_open'] = "0";
        }
        
    } else if(substr_count($xc['days'],$day."(CLOSE)") > 0){
        $dd['is_open'] = "0";
    } else {
        $dd['is_open'] = "0";
    }
    
    $dd['time'] = date("g:i a", strtotime($xc['close']));
    
    $getResult = query("select open, close from manual_market_results where market='$market' AND date='$date'");
    if(rows($getResult) > 0){
        
        $dd['is_open'] = "0";
        
        $result = fetch($getResult);
        
        $dd['result'] = $result['open'].$result['close'];
    } else {
        $dd['result'] = "-";
    }
    
      //  $dd['result'] = "-";
        
        $dd['market'] = $xc['market'];
  
    if(rows(query("select * from gametime_delhi where market='$market' AND close > str_to_date('$time_id', '%H:%i') limit 1")) > 0){
    
        $dd['is_close'] = "1";
        
    } else {
        $dd['is_close'] = "0";
    }
  
  	//$dd['result'] = $xc['market'].' - '.$dd['result'];
  	$dd['result'] = $dd['result'];
  	$dd['name2'] = $xc['market'];
        
    $data['data'][] = $dd;
}

echo json_encode($data);