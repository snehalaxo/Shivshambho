<?php
include "../connection/config.php";
extract($_REQUEST);
$date = date('d/m/Y');

if((int)$total < 10){
    $data['success'] = "0";
    $data['msg'] = "Minimum bet amount should be 10 INR";
        
    echo json_encode($data);
    return;
}

$check = query("select wallet from users where mobile='$mobile' AND wallet < '$total'");

if(rows($check) == 0)
{
    
    $bazar = str_replace(" ","_",$bazar);

    query("update users set wallet=wallet-'$total' where mobile='$mobile'");
    
    query("INSERT INTO `games`(`user`, `game`, `bazar`, `date`, `number`, `amount`, `created_at`) VALUES ('$mobile','$game','$bazar','$date','$number','$amount','$stamp')");
    
    $data['success'] = "1";

}
else
{
    $data['success'] = "0";
    $data['msg'] = "You don't have enough wallet balance";
}

echo json_encode($data);