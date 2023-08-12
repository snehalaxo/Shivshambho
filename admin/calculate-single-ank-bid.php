<?php 
    $gameID = $_POST['gameID'];
    $session = $_POST['session'];
    
    $currDate = date('d/m/Y');
    
    include('config.php');
    
    $singleAnk = mysqli_query($con, "SELECT * FROM `single_digit` ORDER BY number ASC ");
    
    while($row = mysqli_fetch_array($singleAnk)){
    
    $digit = $row['number'];
    
    id
?>

<div class="col mb-4">
    <div class="box" style="box-shadow: 0px 1px 10px #ccc; border-radius: 10px; padding:5px;">
        <p class="text-center"><b>Total Bids 
            <?php
                if($session == 'open'){
                    
                    $mrk2 = str_replace(" ","_",$gameID.' OPEN');
                    $BidHistory = mysqli_query($con, "SELECT * FROM `games` WHERE `game`='single' AND `date`='$currDate' AND `bazar`='$mrk2' AND `number`='$digit' ");
                }elseif($session == 'close'){
                    $mrk2 = str_replace(" ","_",$gameID.' CLOSE');
                    $BidHistory = mysqli_query($con, "SELECT * FROM `games` WHERE `game`='single' AND `date`='$currDate' AND `bazar`='$mrk2' AND `number`='$digit' ");
                }
                
                $count = mysqli_num_rows($BidHistory);
                echo $count;
            ?>
        </b></p>
        <h3 class="text-center">
            <?php
                if($session == 'open'){
                    
                    $mrk2 = str_replace(" ","_",$gameID.' OPEN');
                    $BidHistoryTotal = mysqli_query($con, "SELECT SUM(amount) as TotalPoints FROM `games` WHERE `game`='single' AND `date`='$currDate' AND `bazar`='$mrk2' AND `number`='$digit' ");
                }elseif($session == 'close'){
                    $mrk2 = str_replace(" ","_",$gameID.' CLOSE');
                    $BidHistoryTotal = mysqli_query($con, "SELECT SUM(amount) as TotalPoints FROM `games` WHERE `game`='single' AND `date`='$currDate' AND `bazar`='$mrk2' AND `number`='$digit' ");
                }
            
                
                $fetch = mysqli_fetch_array($BidHistoryTotal);
                
                if($fetch['TotalPoints'] == 0){
                    echo "0";
                }else{
                    echo $fetch['TotalPoints'];
                }
                
            ?>
        </h3>
        <p class="text-center">Total Bid Amount</p>
        <h6 class="bg-primary text-center text-light">Ank <?php echo $digit; ?></h6>
    </div>
</div>

<?php
}
?>