<?php
include "../admin/connection/config.php";
extract($_REQUEST);


$get = query("select * from gametime_manual");
while($xc = fetch($get))
{ 
   $data['data'][] = $xc;	
}


$get = query("select * from starline_markets");
while($xc = fetch($get))
{
    
    
   $chts['market'] = $xc['name'];
            
            $data['data'][] = $chts;
	
}




$get = query("select * from gametime_delhi");
while($xc = fetch($get))
{ 
   $data['data'][] = $xc;	
}


echo json_encode($data);