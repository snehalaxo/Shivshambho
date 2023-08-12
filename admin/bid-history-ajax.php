  <table id="example1" class="w-100 table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Mobile Number</th>
                    <th>Bid TXID</th>
                    <th>Game Name</th>
                    <th>Game Type</th>
                    <th>Session</th>
                    <th>Number</th>
                    <th>Points</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="tbody">

<?php
     $date_str = strtotime($_POST['date']);
     $date = date('d/m/Y', $date_str);
     $gameID = $_POST['gameID'];
     $gameType = $_POST['gameType'];

 $chec_date = strtotime('-29 days');
 
 

$num_results_on_page = 10;  
if (isset($_GET["page"])) {
	$page  = $_GET["page"]; 
	} 
	else{ 
	$page=1;
	};  
$start_from = ($page-1) * $num_results_on_page;  

$search_url_add = "";

	
if($chec_date < $date_str){
 $table_name = "games"; 
} else {
 $table_name = "games_archive"; 
}
     
    $market = str_replace(" ","_",$gameID);
    $market_1 = str_replace(" ","_",$gameID.' OPEN');
    $market_2 = str_replace(" ","_",$gameID.' CLOSE');

    include('config.php');
    if($date != '' && $gameID != '' && $gameType != ''){
        $select = mysqli_query($con, "SELECT * FROM `$table_name` WHERE `date`= '$date' AND (`bazar`='$market' OR `bazar`='$market_1' OR `bazar`='$market_2' ) AND `game`='$gameType'"); 
        
    
    }elseif($date != '' && $gameID != '' && $gameType == ''){
        $select = mysqli_query($con, "SELECT * FROM `$table_name` WHERE `date`= '$date' AND (`bazar`='$market' OR `bazar`='$market_1' OR `bazar`='$market_2' ) "); 

        
        
    }
           

$action_url = "&page=".$page.$search_url_add;


$row_db = mysqli_fetch_row($result_db);  
$total_pages = $row_db[0];  

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;


    
   $i = 1;
     $i = (($page-1)*10)+1;
    while($row = mysqli_fetch_array($select)){
        // user data
        $userID = $row['user'];
        $user = mysqli_query($con, "SELECT * FROM `users` WHERE `mobile`='$userID' ");
        $fetch = mysqli_fetch_array($user);
        
        $game_id = $row['bazar'];
?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><?php if($fetch['name'] != ''){ echo $fetch['name'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($fetch['mobile'] != ''){ echo $fetch['mobile'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($row['sn'] != ''){echo $row['sn'];}else{ echo 'N/A'; } ?></td>
        <td><?php echo $game_id; ?></td>
        <td style="text-transform: capitalize;"><?php if($row['game'] != ''){echo $row['game'];}else{ echo 'N/A'; } ?></td>
        <td style="text-transform: capitalize;"><?php if('' != ''){echo $row['session'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($row['number'] != ''){echo $row['number'];}else{ echo 'N/A'; } ?></td>
        <td><?php if($row['amount'] != ''){echo $row['amount'];}else{ echo 'N/A'; } ?></td>
        <td><a class="btn btn-info" href="update-bid-history.php?id=<?php echo $row['sn']; ?>">Edit</a></td>
    </tr>    
    

<?php
$i++;
    }
?>

 </tbody>
</table>
