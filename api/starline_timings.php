<?php
include "../connection/config.php";
extract($_REQUEST);

$time = date("H:i",$stamp);
$day = strtoupper(date("l",$stamp));
$date = date("d/m/Y");

$mrk = fetch(query("select * from starline_markets where name='$market'"));

$get_timings = query("select * from starline_timings where market='$market' order by str_to_date(close, '%H:%i')");

$sx = query("SELECT * FROM `rates_delhi` where sn='1'");
$x = fetch($sx);
$data = $x;

while($xc = fetch($get_timings)){
    
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
    
    $getResult = query("select number, panna from starline_results where market='$market' AND timing='$time_id' AND date='$date'");
    if(rows($getResult) > 0){
        
        $dd['is_open'] = "0";
        
        $result = fetch($getResult);
        
        $dd['result'] = $result['panna'].'-'.$result['number'];
    } else {
        $dd['result'] = "-";
    }
    
       // $dd['result'] = "-";
        
        $dd['name'] = $xc['name'];
      //  echo "select * from starline_timings where market='$market' AND close > str_to_date($time_id, '%H:%i') limit 1";
    if(rows(query("select * from starline_timings where market='$market' AND close > str_to_date('$time_id', '%H:%i') limit 1")) > 0){
    
        $dd['is_close'] = "1";
        
    } else {
        $dd['is_close'] = "0";
    }
        
    $data['data'][] = $dd;
}

echo json_encode($data);