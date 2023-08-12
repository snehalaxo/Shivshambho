<?php
include "../connection/config.php";
extract($_REQUEST);

$sx = query("SELECT * FROM `withdraw_options` where active='1' order by name");
while($x = fetch($sx))
{
    $data['data'][] = $x;
}

echo json_encode($data);