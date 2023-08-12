<?php
include "../connection/config.php";
extract($_REQUEST);

if(rows(query("select sn from users where mobile='$mobile' and session ='$session'")) == 0){
    $data['msg'] = "You are not authrized to use this";
      
    $dd = query("select session,active from users where mobile='$mobile'");
    $d = fetch($dd);
    $data['session'] = $d['session'];
    $data['active'] = $d['active'];
    
    echo json_encode($data);
    return;
} else {
          
    $dd = query("select session,active from users where mobile='$mobile'");
    $d = fetch($dd);
    $data['session'] = $d['session'];
    $data['active'] = "1";
}

$time = date("H:i",$stamp);
$day = strtoupper(date("l",$stamp));

$nm = explode(",",$number);
$am = explode(",",$amount);

if(isset($_REQUEST['types'])){
    $type = explode(",",$types);
}

if(isset($_REQUEST['games'])){
    $game_array = explode(",",$games);
}


$_bazar = str_replace("_OPEN","",$bazar);
$_bazar = str_replace("_CLOSE","",$_bazar);
$_bazar = str_replace("_"," ",$_bazar);

$date = date('d/m/Y');

$check = query("select wallet from users where mobile='$mobile' AND wallet < '$total'");


if(isset($_REQUEST['timing'])){
    
    $timing  = date("H:i", strtotime($_REQUEST['timing']));
    
    $mrk = fetch(query("select * from starline_markets where name='$bazar'"));
    
    $get_timings = query("select * from starline_timings where market='$bazar' AND close='$timing'");
    
    // echo "select * from starline_timings where market='$bazar' AND close='$timing'";
    // return;
    
    $xc = fetch($get_timings);
    
    if($mrk['days'] == "" || substr_count($mrk['days'],$day) == 0){
    
        if(strtotime($time)<strtotime($xc['close'])) {
            $ddx['is_open'] = "1";
        } else {
            $ddx['is_open'] = "0";
        }
        
    } else if(substr_count($xc['days'],$day."(CLOSE)") > 0){
        $ddx['is_open'] = "0";
    } else {
        $ddx['is_open'] = "0";
    }
    
    
    if($ddx['is_open'] == "0"){
        $data['success'] = "0";
        $data['msg'] = "Market Already Closed";
    }
    else if(rows($check) == 0)
    {
    
    
    	$msg = "New bets game - ".$game.", bazar - ".$bazar.", user-".$mobile.", bets - ";
        
        for($a = 0;$a < count($am) ; $a++)
        {
            $amoun = $am[$a];
            $numbe = $nm[$a];
            
            $getName = fetch(query("select name from starline_timings where market='$bazar' AND close='$timing'"));
            
            $bet['amount'] = $amoun;
            $bet['number'] = $numbe;
            $bet['game'] = $game;
            $bet['market'] = $getName['name'];
            
            $bets[] = $bet;
    
    		$msg = $msg."( Num-".$numbe." - ".$amoun."INR )";
    		
    		
    $check = query("select wallet from users where mobile='$mobile'");
        

$check_wallet = fetch($check);

            $wallet = $amoun;
            
            if($amoun < 10){
                    
                $data['success'] = "0";
                $data['msg'] = "Minimum bet amount is 10 INR";
                echo json_encode($data);
                return;
            }
          
            
            if(($check_wallet['wallet']) < $wallet){
                 
                $data['success'] = "0";
                $data['msg'] = "You don't have enough wallet balance to place this bet";
                echo json_encode($data);
                return;
                
            } else {
                
                $deposit = $wallet;
                
            }
            
                    query("update users set wallet=wallet-'$deposit' where mobile='$mobile'");
        
    		
        //      query("update users set wallet=wallet-'$amoun' where mobile='$mobile'");
            
            query("INSERT INTO `starline_games`(`user`, `game`, `bazar`, `date`, `number`, `amount`, `created_at`,`timing_sn`) VALUES ('$mobile','$game','$bazar','$date','$numbe','$amoun','$stamp','$timing')");
            
            query("INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`owner`) VALUES ('$mobile','$amoun','0','Bet Placed','$stamp','$mobile')");
            
        }
        
        query("INSERT INTO `notifications`( `msg`, `created_at`) VALUES ('$msg','$stamp')");
        
        $data['success'] = "1";
        $data['bets'] = $bets;;
    
    }
    else
    {
        $data['success'] = "0";
        $data['msg'] = "You don't have enough wallet balance";
    }
    
} else {
$get_mrkt = query("select * from gametime_new where market='$_bazar'");

if(rows($get_mrkt) == 0){
    $get_mrkt =  query("select * from gametime_manual where market='$_bazar'");
    
    if(rows($get_mrkt) == 0){
        
      
         $get_mrkt =  query("select * from gametime_delhi where market='$_bazar'");
    
        if(rows($get_mrkt) == 0){

            $data['success'] = "0";
            $data['msg'] = "We are not able to get market details, Please restart application and try again";
            echo json_encode($data);
            return;

        }
        
    }
}

$xc = fetch($get_mrkt);

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
    
} else if(substr_count($xc['days'],$day."(CLOSE)") > 0){
       
       
        $data['success'] = "0";
        $data['msg'] = "Market already closeed, Try again later";
        echo json_encode($data);
        return;
       
       
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



if(rows($check) == 0)
{

	$msg = "New bets game - ".$game.", user-".$mobile.", bets - ";
    
    for($a = 0;$a < count($am) ; $a++)
    {
        $amoun = $am[$a];
        $numbe = $nm[$a];
        
        if(isset($_REQUEST['types'])){
            if($game == "jodi"){
                $bazar2 = $bazar;
            } else {
                $bazar2 = $bazar."_".$type[$a];
            }
        } else {
            $bazar2 = $bazar;
        }
        
        // if(isset($_REQUEST['games'])){
        //     $game = $game_array[$a];
        // }
        
        $bazar2 = str_replace(' ',"_",$bazar2);
        
        
		$check = query("select wallet from users where mobile='$mobile' AND wallet < '$amoun'");
        if(rows($check) > 0)
		{
          $data['success'] = "0";
                $data['msg'] = "You don't have enough wallet balance";
                echo json_encode($data);
                return;
            
        }
        if (strpos($bazar2, 'OPEN') !== false) {
            if($xc['is_open'] == "0"){
                $data['success'] = "0";
                $data['msg'] = "Market already closeed, Try again later";
                echo json_encode($data);
                return;
            }
            
	    
    	    $chk_if_query = query("select * from manual_market_results where market='$bazar' AND date='$date'");
            if(rows($chk_if_query) > 0){
                
                $data['success'] = "0";
                $data['msg'] = "Market already closeed, Try again later";
                echo json_encode($data);
                return;
                
            } 
        
            
        } else if (strpos($bazar2, 'CLOSE') !== false) {
            
            if($xc['is_close'] == "0"){
                 $data['success'] = "0";
                $data['msg'] = "Market already closeed, Try again later";
                echo json_encode($data);
                return;
            }
            
            
    	    $chk_if_query = query("select * from manual_market_results where market='$bazar' AND date='$date'");
            if(rows($chk_if_query) > 0){
                
                $chk_if_updated = fetch($chk_if_query);
            
                 
                if($chk_if_updated['close'] != ''){
                   
                    $data['success'] = "0";
                    $data['msg'] = "Market already closeed, Try again later";
                    echo json_encode($data);
                    return;
                   
                } 
                
                
            } 
            
        } else if ($game == "jodi" || $game == "halfsangam" || $game == "fullsangam") {
            
           if($xc['is_open'] == "0"){
                 $data['success'] = "0";
                $data['msg'] = "Market already closeed, Try again later";
                echo json_encode($data);
                return;
            }
            
            
    	    $chk_if_query = query("select * from manual_market_results where market='$bazar' AND date='$date'");
            if(rows($chk_if_query) > 0){
                
                $data['success'] = "0";
                $data['msg'] = "Market already closeed, Try again later";
                echo json_encode($data);
                return;
                
            } 
            
        }
    

           if($amoun < 10){
                    
                $data['success'] = "0";
                $data['msg'] = "Minimum bet amount is 10 INR";
                echo json_encode($data);
                return;
            }
          
        
   		 query("update users set wallet=wallet-'$amoun' where mobile='$mobile'");

        

		$msg = $msg."( Market - ".$bazar2." , Num-".$numbe." - ".$amoun."INR )";
        
        query("INSERT INTO `games`(`user`, `game`, `bazar`, `date`, `number`, `amount`, `created_at`) VALUES ('$mobile','$game','$bazar2','$date','$numbe','$amoun','$stamp')");
    }
    
    query("INSERT INTO `notifications`( `msg`, `created_at`) VALUES ('$msg','$stamp')");


    $data['success'] = "1";

}
else
{
    $data['success'] = "0";
    $data['msg'] = "You don't have enough wallet balance";
}

$data['$type'] = $types;

}

echo json_encode($data);