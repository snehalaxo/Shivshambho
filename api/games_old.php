<?php
include "../connection/config.php";
extract($_REQUEST);

$sx = query("SELECT * FROM `games_archive` where user='$mobile' order by created_at desc");
while($x = fetch($sx))
{
    $x['date'] = date('d M Y',$x['created_at']);
    $data['data'][] = $x;
}

echo json_encode($data);