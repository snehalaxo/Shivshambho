<?php include('config.php');
$date2 = $_REQUEST['resultDate'];

     $date_str = strtotime($_POST['resultDate']);
$date = date('d/m/Y',$date_str);
$market = str_replace(" ","_",$_REQUEST['gameID']); 
$amount = $_REQUEST['amount'];

 $chec_date = strtotime('-29 days');
	
if($chec_date < $date_str){
 $table_name = "games"; 
} else {
 $table_name = "games_archive"; 
}
   
 $mrk = str_replace(' ','_',$market.' OPEN');
 $mrk3 = str_replace(' ','_',$market.' CLOSE');
  $mrk2 = str_replace(' ','_',$market.'');
 
  
  $qry = "SELECT * FROM $table_name WHERE (bazar='$mrk' OR bazar='$mrk2' OR bazar='$mrk3')  AND date='$date' AND amount >= $amount";


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
                                <td><?php echo $row['game']; ?></td>
                                <td><?php echo $row['number']; ?></td>
                                <td><?php echo date('h:i A d-m-Y',$row['created_at']); ?></td>
                            </tr>
                    <?php
                            $i++;
                        }
                    ?>