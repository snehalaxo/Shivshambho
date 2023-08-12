<?php include('config.php');
$date2 = $_REQUEST['date'];

$date = date('d/m/Y',strtotime($_REQUEST['date']));


$digit = $_REQUEST['digit'];
$panna = $_REQUEST['panna'];
$session = $_REQUEST['session'];
$market = $_REQUEST['market'];

$get_rates = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `rate`"));


if($session == 'open'){
  $mrk = str_replace(' ','_',$market.' OPEN');
  
  $qry = "SELECT * FROM games WHERE bazar='$mrk' AND (number='$digit' OR number='$panna') AND date='$date'";
  
} else {

  
  $chk_if_query = mysqli_query($con, "select * from manual_market_results where market='$market' AND date='$date'");
  $chk_if_updated = mysqli_fetch_array($chk_if_query);

  $open = $chk_if_updated['open'];
  $opanna = $chk_if_updated['open_panna'];

  $mrk = str_replace(' ','_',$market.' CLOSE');
  $mrk2 = str_replace(' ','_',$market.'');
  
  $jodi = $open.$digit;
  
  $half1 = $opanna.'-'.$digit;
  $half2 = $panna.'-'.$open;
  
  $full = $opanna.'-'.$panna;
  
  $qry = "SELECT * FROM games WHERE (bazar='$mrk' OR bazar='$mrk2') AND (number='$digit' OR number='$panna' OR number='$jodi' OR number='$half1' OR number='$half2' OR number='$full') AND date='$date'";
  
}

?>

<?php
                        $winning = mysqli_query($con, $qry);
                        $i = 1;
                        while($row = mysqli_fetch_array($winning)){
                            $userID = $row['user'];
                            $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$userID' ");
                            $fetch = mysqli_fetch_array($user);
                                                    
                    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $fetch['name']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $get_rates[$row['game']]*$row['amount']; ?></td>
                                <td><?php echo $row['bazar']; ?></td>
                                <td><?php echo $row['game']; ?></td>
                                <td><?php echo $row['number']; ?></td>
                                <td><?php echo date('h:i A d-m',$row['created_at']); ?></td>
                              <td>
                                <a href="user-profile.php?userID=<?php echo $row['user']; ?>"><i class="fas fa-eye" style="font-size:25px;"></i></a>
                              </td>
                            </tr>
                    <?php
                            $i++;
                        }
                    ?>