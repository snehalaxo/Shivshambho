<?php
include "../connection/config.php";
extract($_REQUEST);


if(rows(query("select sn from users where mobile='$mobile' and session ='$session'")) == 0){
    $data['msg'] = "You are not authrized to use this";
      
    $dd = query("select session,active from users where mobile='$mobile'");
    $d = fetch($dd);
    $data['session'] = "0";
    $data['active'] = "0";
    
    echo json_encode($data);
    return;
} else {
  
    $data['session'] = "1";
    $data['active'] = "1";
}
$day = strtoupper(date("l",$stamp));
$date = date('d/m/Y');

//$curr_datetime = date("Y-m-d "+"00:00:00");

$get = query("select * from gametime_manual order by open");
while($xc = fetch($get))
{
    
    $time = date("H:i",$stamp);

    if($xc['days'] == "ALL" || substr_count($xc['days'],$day) == 0){
        if(strtotime($time)<strtotime($xc['open']))
        {
            $xc['is_open'] = "1";
        }
        else
        {
            $xc['is_open'] = "0";
        }
        
        if(strtotime($time)<strtotime($xc['close']))
        {
            $xc['is_close'] = "1";
        }
        else
        {
            $xc['is_close'] = "0";
        }
    } else if(substr_count($xc['days'],$day."(CLOSED)") > 0){
        $xc['is_open'] = "0";
        $xc['is_close'] = "0";
        $xc['open'] = "CLOSE";
        $xc['close'] = "CLOSE";
        $xc['open_time'] = "CLOSE";
        $xc['close_time'] = "CLOSE";
    } else {
        $time_array = explode(",",$xc['days']);
        for($i =0;$i< count($time_array);$i++){
            if(substr_count($time_array[$i],$day) > 0){
                $day_conf = $time_array[$i];
            }
        }
        
        $day_conf = str_replace($day."(","",$day_conf);
        $day_conf = str_replace(")","",$day_conf);
        
        $mrk_time = explode("-",$day_conf);
        
        
        $xc['open'] = $mrk_time[0];
        $xc['close'] = $mrk_time[1];
        
        if(strtotime($time)<strtotime($mrk_time[0]))
        {
            $xc['is_open'] = "1";
        }
        else
        {
            $xc['is_open'] = "0";
        }
        
        if(strtotime($time)<strtotime($mrk_time[1]))
        {
            $xc['is_close'] = "1";
        }
        else
        {
            $xc['is_close'] = "0";
        }
    }
    
    $bazar = $xc['market'];
    
    $chk_if_query = query("select * from manual_market_results where market='$bazar' AND date='$date'");
    if(rows($chk_if_query) > 0){
        
        $xc['is_open'] = "0";
        $chk_if_updated = fetch($chk_if_query);
    
         
        if($chk_if_updated['close'] != ''){
           
            $xc['is_close'] = "0";
           
        } 
        
        
    } 
    
    $mrk['market'] = $xc['market'];
    $market  = $xc['market'];
    $date = date("d/m/Y");
    
    $chk_if_query = query("select * from manual_market_results where market='$market' AND date='$date'");
    if(rows($chk_if_query) > 0){
        
    $chk_if_updated = fetch($chk_if_query);
    
        $rslt = $chk_if_updated['open_panna'].'-'.$chk_if_updated['open'];
        
        if($chk_if_updated['close'] != ''){
            $rslt = $rslt.$chk_if_updated['close'];
        } else {
             $rslt = $rslt.'*';
        }
        
         if($chk_if_updated['close_panna'] != ''){
            $rslt = $rslt.'-'.$chk_if_updated['close_panna'];
        } else {
            $rslt = $rslt.'-***';
        }
        
        
    } else {
        
         
      if (((int) date('H')) < 6) {
        $date2 = date('d/m/Y',strtotime("-1 days"));
         $chk_if_query = query("select * from manual_market_results where market='$market' AND date='$date2'");
          if(rows($chk_if_query) > 0){

          $chk_if_updated = fetch($chk_if_query);

              $rslt = $chk_if_updated['open_panna'].'-'.$chk_if_updated['open'];

              if($chk_if_updated['close'] != ''){
                  $rslt = $rslt.$chk_if_updated['close'];
              } else {
                   $rslt = $rslt.'*';
              }

               if($chk_if_updated['close_panna'] != ''){
                  $rslt = $rslt.'-'.$chk_if_updated['close_panna'];
              } else {
                  $rslt = $rslt.'-***';
              }


          } else {
      
        $rslt = "***-**-***";
        
      }
      } else {
      
        $rslt = "***-**-***";
        
      }
        
    }
    
    
    $mrk['is_close'] = $xc['is_close'];
    $mrk['is_open'] = $xc['is_open'];
    
    if($xc['open_time'] != "CLOSE"){
    $mrk['open_time'] = date("g:i a", strtotime($xc['open']));
    } else {
    //  $mrk['open_time'] = "HOLIDAY";
    }
  if($xc['close_time'] != "CLOSE"){
    $mrk['close_time'] = date("g:i a", strtotime($xc['close']));
  }else {
   //   $mrk['close_time'] = "HOLIDAY";
    }
	$mrk['result'] = $rslt;
    $data['result'][] = $mrk;
}
$today = date("m-d-y ");
   $name = 'open_time';
   usort($data['result'], function ($a, $b) use(&$name){
      return strtotime($today.' '.$a[$name]) - strtotime($today.' '.$b[$name]);});


$dd = query("select sn,wallet,active,session,code,transfer_points_status,paytm,verify,name,email from users where mobile='$mobile'");
$d = fetch($dd);

$nt = query("select homeline from content where sn='1'");
$n = fetch($nt);

if($d['code'] == "0")
{
    $code = $d['sn'].rand(100000,9999999);
    query("update users set code='$code' where mobile='$mobile'");
}
else
{
    $code = $d['code'];
}


$getConfig = query("select * from settings");
while($config = fetch($getConfig)){
    
    $data[$config['data_key']] = $config['data'];
}

if(rows(query("select sn from gateway_config where active='1'")) > 0){
    $data['gateway'] = "1";
} else {
    $data['gateway'] = "0";
}


$getConfig = query("select * from image_slider where verify='".$d['verify']."'");
//$getConfig = query("select * from image_slider where verify='1' AND screen='matka'");
while($config = fetch($getConfig)){
    
    if($config['refer'] == "market"){
        for($i = 0; $i < count($data['result']); $i++){
            if($data['result'][$i]['market'] == $config['data'] && $data['result'][$i]['is_close'] == "1"){
                
                $config['market'] = $data['result'][$i]['market'];
                $config['is_open'] = $data['result'][$i]['is_open'];
                $config['is_close'] = $data['result'][$i]['is_close'];
                $config['open_time'] = $data['result'][$i]['open_time'];
                $config['close_time'] = $data['result'][$i]['close_time'];
                
                $data['images'][] = $config;
            }
            
        }
        
    } else {
        $data['images'][] = $config;
    }
}

$data['transfer_points_status'] = $d['transfer_points_status'];
$data['paytm'] = $d['paytm'];
$data['code'] = $code;
$data['verify'] = $d['verify'];
$data['wallet'] = $d['wallet'];
$data['active'] = $d['active'];
$data['session'] = $d['session'];
$data['homeline'] = $n['homeline'];
$data['name'] = $d['name'];
$data['email'] = $d['email'];

echo json_encode($data);