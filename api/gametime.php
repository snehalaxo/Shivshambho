<?php
include "../connection/config.php";
extract($_REQUEST);

$sx = query("SELECT * FROM `gametime` where sn='1'");
$x = fetch($sx);
$data = $x;

echo json_encode($data);