<?php include('header.php'); 

//print_r($_REQUEST);
if(isset($_REQUEST['submit_manual2'])){
  extract($_REQUEST);
  
    
 // echo "location:winners.php?date=$date&session=$session&digit=$digit&panna=$panna&market=$market";
  echo "<script>window.location.href = 'winners.php?date=$date&session=$session&digit=$digit&panna=$panna&market=$market'</script>";
  
}

if(isset($_REQUEST['submit_manual'])){
    extract($_REQUEST);
    
    $date = date('d/m/Y',strtotime($_REQUEST['date']));
    
    if($session == 'open'){
        $open = $digit;
        $opanna = $panna;
        
        if($open == "" && $opanna == ""){
             echo "<script>window.location.href = 'declare-result.php?error=Not%20a%20valid%20result'</script>";
             exit();
        }
        
    } else {
        
        $chk_if_query = mysqli_query($con, "select * from manual_market_results where market='$market' AND date='$date'");
        $chk_if_updated = mysqli_fetch_array($chk_if_query);
        
        $open = $chk_if_updated['open'];
        $opanna = $chk_if_updated['open_panna'];
        $close = $digit;
        $cpanna = $panna;
        
         
        if($open == "" && $opanna == ""){
             echo "<script>window.location.href = 'declare-result.php?error=Not%20a%20valid%20result'</script>";
             exit();
        }
    }
    
    

    $chk_if_query = mysqli_query($con, "select sn from manual_market_results where market='$market' AND date='$date'");
    if(mysqli_num_rows($chk_if_query) > 0){
        $chk_if_updated = mysqli_fetch_array($chk_if_query);
        $sn = $chk_if_updated['sn'];
        mysqli_query($con, "update manual_market_results set close='$close', close_panna='$cpanna' where sn='$sn'");
    } else {
        
        mysqli_query($con, "INSERT INTO `manual_market_results`(`market`, `date`, `open_panna`, `open`, `close`, `close_panna`, `created_at`) VALUES ('$market','$date','$opanna','$open','$close','$cpanna','$stamp')");
        
    }
    
    /////////////////////////
    //// CREATING BATCH /////
    /////////////////////////
    
    $batch_id = md5($stamp.$market.rand().$open.$close.$date.$day.$time);
    
    $batch_result = $opanna.'-'.$open.$close.'-'.$cpanna;
        
    mysqli_query($con, "INSERT INTO `manual_batch`( `market`, `result`, `revert`, `created_at`, `batch_id`,`date`) VALUES ('$market','$batch_result','0','$stamp','$batch_id','$date')");
    
    $xvm = mysqli_query($con, "select * from rate where sn='1'");
    $xv = mysqli_fetch_array($xvm);
    
    if($open != ""){
        
        $mrk = str_replace(" ","_",$market.' OPEN');
    
        $xx = mysqli_query($con, "select * from games where bazar='$mrk' AND game='single' AND date='$date' AND number='$open' AND status='0' AND is_loss='0'");
        
        while($x = mysqli_fetch_array($xx))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
            
            $remrk = $x['game']." ".$x['bazar']." Winning";
        
            mysqli_query($con, "update games set status='1' where sn='$sn'");
            
          
            mysqli_query($con, "update users set wallet=wallet+'$amount' where mobile='$user'");
            
            mysqli_query($con, "INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`batch_id`,`game_id`) VALUES ('$user','$amount','1','$remrk','$stamp','$batch_id','$sn')");
            
                            
            $msg = "You won ".$amount." for your ".$mrk.' '.$x['game'].' game';
             
            sendNotification("Congratulations, You won",$msg,$user);
            
        }
        
        mysqli_query($con, "UPDATE games set is_loss='1' where bazar='$mrk' AND game='single' AND date='$date' AND number!='$open' AND is_loss='0'");
        
    
    }
    
    if($opanna != ""){
        
        
        $bazar = str_replace(" ","_",$market.' OPEN');
        
        $xx = mysqli_query($con, "select * from games where bazar='$bazar' AND ( game='singlepatti' OR  game='doublepatti' OR  game='triplepatti' ) AND date='$date' AND number='$opanna' AND status='0' AND is_loss='0'");
        

        while($x = mysqli_fetch_array($xx))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
            
            
            if(mysqli_num_rows(mysqli_query($con, "select sn from games where sn='$sn' AND status='0'")) > 0){
        
                mysqli_query($con, "update games set status='1' where sn='$sn'");
            
                mysqli_query($con, "update users set wallet=wallet+'$amount' where mobile='$user'");
                
             
                $remrk = $x['game']." ".$x['bazar']." Winning";
                
                mysqli_query($con, "INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`batch_id`,`game_id`) VALUES ('$user','$amount','1','$remrk','$stamp','$batch_id','$sn')");
                                 
            $msg = "You won ".$amount." for your ".$mrk.' '.$x['game'].' game';
             
            sendNotification("Congratulations, You won",$msg,$user);
             
            }
            
        } 
        
        mysqli_query($con, "UPDATE games set is_loss='1' where bazar='$bazar' AND ( game='singlepatti' OR  game='doublepatti' OR  game='triplepatti' ) AND date='$date' AND number!='$opanna' AND status='0' AND is_loss='0'");
    
    }
    
    if($close != ""){
        
        
        $bazar = str_replace(" ","_",$market.' CLOSE');
        
        $xx = mysqli_query($con, "select * from games where bazar='$bazar' AND game='single' AND date='$date' AND number='$close' AND status='0' AND is_loss='0'");
                            
        while($x = mysqli_fetch_array($xx))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
            
            
            if(mysqli_num_rows(mysqli_query($con, "select sn from games where sn='$sn' AND status='0'")) > 0){
        
                mysqli_query($con, "update games set status='1' where sn='$sn'");
            
                mysqli_query($con, "update users set wallet=wallet+'$amount' where mobile='$user'");
                
                $remrk = $x['game']." ".$x['bazar']." Winning";
                
                mysqli_query($con, "INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`batch_id`,`game_id`) VALUES ('$user','$amount','1','$remrk','$stamp','$batch_id','$sn')");
                                 
            $msg = "You won ".$amount." for your ".$mrk.' '.$x['game'].' game';
             
            sendNotification("Congratulations, You won",$msg,$user);
            }
        } 
        
        
        mysqli_query($con, "UPDATE games set is_loss='1' where bazar='$bazar' AND game='single' AND date='$date' AND number!='$close' AND status='0' AND is_loss='0'");
    
    }
    
    if($cpanna != ""){
        
        
        $bazar = str_replace(" ","_",$market.' CLOSE');
        
        $xx = mysqli_query($con, "select * from games where bazar='$bazar' AND ( game='singlepatti' OR  game='doublepatti' OR  game='triplepatti' ) AND date='$date' AND number='$cpanna' AND status='0' AND is_loss='0'");
        
                            
        while($x = mysqli_fetch_array($xx))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
            
            
            if(mysqli_num_rows(mysqli_query($con, "select sn from games where sn='$sn' AND status='0' AND is_loss='0'")) > 0){
        
                mysqli_query($con, "update games set status='1' where sn='$sn'");
            
                mysqli_query($con, "update users set wallet=wallet+'$amount' where mobile='$user'");
                
                $remrk = $x['game']." ".$x['bazar']." Winning";
                
            mysqli_query($con, "INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`batch_id`,`game_id`) VALUES ('$user','$amount','1','$remrk','$stamp','$batch_id','$sn')");
                                 
            $msg = "You won ".$amount." for your ".$mrk.' '.$x['game'].' game';
             
            sendNotification("Congratulations, You won",$msg,$user);
            
            }
            
        } 
        
        mysqli_query($con, "UPDATE games set is_loss='1' where bazar='$bazar' AND ( game='singlepatti' OR  game='doublepatti' OR  game='triplepatti' ) AND date='$date' AND number!='$cpanna' AND status='0' AND is_loss='0'");
    
    }
    
     if($open != "" && $close != ""){
        
        
        $bazar = str_replace(" ","_",$market);
        $bazar2 = str_replace(" ","_",$market.' OPEN');
        $bazar3 = str_replace(" ","_",$market.' CLOSE');
        
        $full_num = $open.$close;
        
        
        $xx = mysqli_query($con, "select * from games where ( bazar='$bazar' OR bazar='$bazar2' OR bazar='$bazar3' ) AND game='jodi' AND date='$date' AND number='$full_num' AND status='0' AND is_loss='0'");
       
        
        while($x = mysqli_fetch_array($xx))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
        
        
            if(mysqli_num_rows(mysqli_query($con, "select sn from games where sn='$sn' AND status='0'")) > 0){
                mysqli_query($con, "update games set status='1' where sn='$sn'");
            
                mysqli_query($con, "update users set wallet=wallet+'$amount' where mobile='$user'");
                
                $remrk = $x['game']." ".$x['bazar']." Winning";
                
            mysqli_query($con, "INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`batch_id`,`game_id`) VALUES ('$user','$amount','1','$remrk','$stamp','$batch_id','$sn')");
                             
            $msg = "You won ".$amount." for your ".$mrk.' '.$x['game'].' game';
             
            sendNotification("Congratulations, You won",$msg,$user);
            }
            
        } 
        
        
        
        mysqli_query($con, "UPDATE games set is_loss='1' where bazar='$bazar' AND game='jodi' AND date='$date' AND number!='$full_num' AND status='0' AND is_loss='0'");
    
    } 
    
    if($opanna != "" && $cpanna != ""){
         
        $full_num = $opanna.' - '.$cpanna;
         
        $bazar = str_replace(" ","_",$market);
        	            
      $xx = mysqli_query($con, "select * from games where bazar like '%$bazar%' AND game='fullsangam' AND date='$date' AND number='$full_num' AND status='0' AND is_loss='0'");
        
       
        while($x = mysqli_fetch_array($xx))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
            
            
            if(mysqli_num_rows(mysqli_query($con, "select sn from games where sn='$sn' AND status='0'")) > 0){
        
                mysqli_query($con, "update games set status='1' where sn='$sn'");
            
                mysqli_query($con, "update users set wallet=wallet+'$amount' where mobile='$user'");
                
                $remrk = $x['game']." ".$x['bazar']." Winning";
                
            mysqli_query($con, "INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`batch_id`,`game_id`) VALUES ('$user','$amount','1','$remrk','$stamp','$batch_id','$sn')");
                             
            $msg = "You won ".$amount." for your ".$mrk.' '.$x['game'].' game';
             
            sendNotification("Congratulations, You won",$msg,$user);
            }
            
        } 
        
        
        mysqli_query($con, "update games set is_loss='1' where bazar like '%$bazar%' AND game='fullsangam' AND date='$date' AND number!='$full_num' AND status='0' AND is_loss='0'");
         
    }
    
    
    
    if($opanna != "" && $cpanna != "" && $open != "" && $close != ""){
        

        $num1 = $opanna.' - '.$close;
        $num2 = $open.' - '.$cpanna;
        
        $xx = mysqli_query($con, "select * from games where bazar like '%$bazar%' AND game='halfsangam' AND date='$date' AND ( number='$num1' or number='$num2') AND status='0' AND is_loss='0'");
        
       // echo "select * from games where bazar like '%$bazar%' AND game='halfsangam' AND date='$date' AND ( number='$num1' or number='$num2') AND status='0' AND is_loss='0'";
                            
        while($x = mysqli_fetch_array($xx))
        {
            $sn = $x['sn'];
            $user = $x['user'];
            $amount = $x['amount']*$xv[$x['game']];
            
            
            if(mysqli_num_rows(mysqli_query($con, "select sn from games where sn='$sn' AND status='0'")) > 0){
        
                mysqli_query($con, "update games set status='1' where sn='$sn'");
            
                mysqli_query($con, "update users set wallet=wallet+'$amount' where mobile='$user'");
                
                $remrk = $x['game']." ".$x['bazar']." Winning";
                
            mysqli_query($con, "INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`batch_id`,`game_id`) VALUES ('$user','$amount','1','$remrk','$stamp','$batch_id','$sn')");
                
                             
            $msg = "You won ".$amount." for your ".$mrk.' '.$x['game'].' game';
             
            sendNotification("Congratulations, You won",$msg,$user);
            }
            
        } 
        
        
        mysqli_query($con, "update games set is_loss='1' where bazar like '%$bazar%' AND game='halfsangam' AND date='$date' AND ( number='$num1' or number='$num2') AND status='0' AND is_loss='0'");
        
    }
     
    $result = "";
    
    if($opanna != ""){
        $result = $opanna.'-';
    } else {
        $result = "***-";
    }    
    
    if($open != ""){
        $result .= $open;
    } else {
        $result .= "*";
    }   
    
    if($close != ""){
        $result .= $close.'-';
    } else {
        $result .= "*".'-';
    }   
    
    if($cpanna != ""){
        $result .= $cpanna;
    } else {
        $result .= "***";
    } 
    
    $body = str_replace("_"," ",$bazar);
    $body = str_replace("OPEN","",$body);
    $body = str_replace("CLOSE","",$body);
    
    $body  = $body.' result';
    

  
   sendNotification($body,$result,"result");
  
    unset($open);
    unset($opanna);
    unset($close);
    unset($cpanna);
    
 // echo "<script>window.location.href = 'declare-result.php'</script>";
}

?>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Declare Result</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
              <li class="breadcrumb-item active">Declare Result</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                
                <?php if(isset($_REQUEST['error'])){ ?>
                
                <div class="alert alert-danger" role="alert">
                    <?php echo $_REQUEST['error']; ?>
                </div>
                
                <?php } ?>
                
                <style>
                    .btn-mobileSelect-gen {
                        width:100% !important;
                    }
                </style>
                
                <div class="card-header">
                    <h3 class="card-title">Filters</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post">
                        
                   
                             
                    <div class="row">
                        <div class="col-sm-12">
                            
                            
                            <div class="row">
                                <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" id="resultDate" value="<?php echo date('Y-m-d'); ?>" class="form-control" />
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label style="width: 100%;">Game</label>
                                    <select id="gameId" name="market" class="form-control select2bs4" style="width: 100%;">
                                        <option value="" selected disabled>Select Game</option>
                                        <?php
                                            $game = mysqli_query($con,  "SELECT * FROM `gametime_new` ORDER BY str_to_date(open, '%H:%i')");
                                            $i = 1;
                                            $currentDate = date('Y-m-d');
                                            while($row = mysqli_fetch_array($game)){
                                               
                                            $xc = getOpenCloseTiming($row);
                                               
                                        ?>
                                            <option value="<?php echo $row['market']; ?>"><?php echo $row['market']; ?> (<?php echo $xc['open'].' - '.$xc['close']; ?>)</option>
                                        <?php
                                                                
                                                
                                            $i++;
                                            }
                                        ?>
                                        <?php
                                            $game = mysqli_query($con,  "SELECT * FROM `gametime_manual` ORDER BY str_to_date(open, '%H:%i')");
                                            $i = 1;
                                            $currentDate = date('Y-m-d');
                                            while($row = mysqli_fetch_array($game)){
                                               
                                               
                                            $xc = getOpenCloseTiming($row);
                                        ?>
                                            <option value="<?php echo $row['market']; ?>"><?php echo $row['market']; ?> (<?php echo $xc['open'].' - '.$xc['close']; ?>)</option>
                                        <?php
                                                                
                                                
                                            $i++;
                                            }
                                        ?>
                                    </select>
                                    </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Session</label>
                                        <select id="session" name="session" class="form-control" style="width: 100%;">
                                            <option value="" selected disabled>Select Session</option>
                                            <option value="open">Open</option>
                                            <option value="close">Close</option>
                                        </select>
                                    </div>
                            </div>
                            </div>
                        
                        </div>
                        
                        <div class="col-sm-12">
                                
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Pana</label>
                                    <select id="pana" name="panna" class="form-control select2bs4" style="width: 100%;">
                                        <option value="" selected disabled>Select Pana</option>
                                        <?php
                                            $panna_numbers = getPatti();
                                            for($x = 0; $x < count($panna_numbers); $x++){
                                        ?>
                                        <option value="<?php echo $panna_numbers[$x]; ?>"><?php echo $panna_numbers[$x]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Digit</label>
                                        <input name="digit" type="number" id="digit" class="form-control" value=""  readonly />
                                    </div>
                            </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            
                            <div class="row">
                                <div class="col-md-12">
                                <div class="form-group mt-2">
                                  
                                      <button type="button" onclick="$(this).hide(); $('#show_buttons').show();" class="btn btn-primary mt-4">SAVE</button>
                                    <div id="show_buttons" style="display:none;">
                                      
                                      <button name="submit_manual" type="submit" class="btn btn-primary mt-4">DECLARE RESULT</button>
                                  
                                    <button id="showResult" type="button" class="btn btn-primary mt-4">SHOW WINNERS</button>
                                      
                                  </div>
                                </div>
                            </div>
                            </div>
                        
                        </div>
                    </div>
                    </form>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.card -->

            <!-- After Save results show buttons Show Winners & Declare Results -->
            <div class="card card-default center" style='display:none'>
                <!-- /.card-header -->
                <div class="card-body">
                    <button type="button" id="showResult" class="btn btn-success">Show Winners</button>
                    <button type="button" id="declareResult" class="btn btn-info">Declare Result</button>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <input type="date" id="PrevResultFilterDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Game Name</th>
                    <th>Result Date</th>
                    <th>Open Pana</th>
                    <th>Close Pana</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="tbody">
                        <?php
                            $currentDate = date('d/m/Y');
                            $result = mysqli_query($con,  "SELECT * FROM `manual_market_results` WHERE `date`='$currentDate' ORDER BY sn DESC");
                            $i = 1;
                            while($row = mysqli_fetch_array($result)){
                               $gameID = $row['market'];
                               
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['market']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['open_panna'].'-'.$row['open']; ?></td>
                                    <td><?php echo $row['close_panna'].'-'.$row['close']; ?></td>
                                    <td>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteResult<?php echo $i; ?>">Delete</button>
                                    </td>
                                </tr>
                                            
                                                <!--Delete Result-->
                                <div class="modal fade" id="deleteResult<?php echo $i; ?>">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                      
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                          <h4 class="modal-title">Are you sure you want to delete this result?</h4>
                                                          
                                                           
                                                          
                                                        </div>
                                                        
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                               <form method="post">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Session</label>
                                                                    <select id="revert_session" name="revert_session" class="form-control" style="width: 100%;" required>
                                                                        <option value="" selected disabled>Select Session</option>
                                                                        <?php if($row['close_panna'] == ""){ ?>
                                                                            <option value="open">Open</option>
                                                                        <?php } ?>
                                                                        <?php if($row['close_panna'] != ""){ ?>
                                                                        <option value="close">Close</option>
                                                                        <?php } ?>
                                                                       
                                                                    </select>
                                                                </div>
                                                            </div>
                                                          
                                                          
                                                       
                                                              <input type="hidden" name="open_panna_revert" value="<?php echo $row['open_panna']; ?>" required/>
                                                              <input type="hidden" name="open_single_revert" value="<?php echo $row['open']; ?>" required/>
                                                              <input type="hidden" name="close_single_revert" value="<?php echo $row['close']; ?>" required/>
                                                              <input type="hidden" name="close_panna_revert" value="<?php echo $row['close_panna']; ?>" required/>
                                                              
                                                              <input type="hidden" name="resultDate" value="<?php echo $row['date']; ?>" required/>
                                                              <input type="hidden" name="gameID" value="<?php echo $gameID; ?>" required/>
                                                              <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                  <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                                                                  <button type="submit" name="deleteResult" class="btn btn-success">Yes</button>
                                                                </div>
                                                          </form>
                                                        </div>
                                                        
                                                        
                                                        
                                                      </div>
                                                    </div>
                                                  </div>
                        <?php
                                $i++;
                            }
                                                
                            if(isset($_POST['deleteResult'])){
                              //  echo $_POST['resultDate'];
                               // $date_ex = explode('-',$_POST['resultDate']);
                                $resultDate = $_POST['resultDate'];
                                $gameID = $_POST['gameID'];
                                $revert_session = $_POST['revert_session'];
                                $open_panna_revert = $_POST['open_panna_revert'];
                                $open_single_revert = $_POST['open_single_revert'];
                                $close_panna_revert = $_POST['close_panna_revert'];
                                $close_single_revert = $_POST['close_single_revert'];
                                
                                if($revert_session == "open"){
                                    //delete result
                                    echo "DELETE FROM `manual_market_results` WHERE `market`='$gameID' AND `date`='$resultDate'";
                                    $deleteResult = mysqli_query($con,  "DELETE FROM `manual_market_results` WHERE `market`='$gameID' AND `date`='$resultDate'");
                                    
                                    $mrk2 = str_replace(" ","_",$gameID.' OPEN');
                                    
                                    
                                    mysqli_query($con," update games set status='0', is_loss='0' where date='$resultDate' AND bazar='$mrk2'");
                                    
                                    $temp_result = $open_panna_revert.'-'.$open_single_revert.'-';
                                    
                                
                                } else if($revert_session == "close"){
                                    
                                    $mrk1 = str_replace(" ","_",$gameID);
                                    $mrk3 = str_replace(" ","_",$gameID.' CLOSE');
                                    
                                    $deleteResult = mysqli_query($con,  "UPDATE `manual_market_results` set close='', close_panna='' WHERE `market`='$gameID' AND `date`='$resultDate'");
                                    
                                    mysqli_query($con," update games set status='0', is_loss='0' where date='$resultDate' AND (bazar='$mrk1' OR bazar='$mrk3')");
                                    
                                    $winHistory = mysqli_query($con,  "SELECT * FROM `manual_batch` WHERE `market`='$gameID' AND `date`='$resultDate' AND revert='0'");
                                    
                                    $temp_result = $open_panna_revert.'-'.$open_single_revert.$close_single_revert.'-'.$close_panna_revert;
                                    
                                }
                                
                                
                                    $winHistory = mysqli_query($con,  "SELECT * FROM `manual_batch` WHERE `market`='$gameID' AND `date`='$resultDate' AND revert='0' AND result='$temp_result'");
                                
                              //  echo "DELETE FROM `manual_market_results` WHERE `market`='$gameID' AND `date`='$resultDate'";
                                                    
                                while($winFetch = mysqli_fetch_array($winHistory)){
                                    $bidTX = $winFetch['batch_id'];
                                    $sn = $winFetch['sn'];
                                    
                                    mysqli_query($con,"update manual_batch set revert='1' where sn='$sn'");
                                    
                                    $result = mysqli_query($con,  "SELECT * FROM `transactions` WHERE `batch_id`='$bidTX'");
                                    while($row = mysqli_fetch_array($result)){
                                        
                                        $game_id = $row['game_id'];
                                        $user = $row['user'];
                                        $amount = $row['amount'];
                                        
                                        
                                       mysqli_query($con, "update users set wallet=wallet-'$amount' where mobile='$user'");
                                       
                                        
                                    }
                                    
                                    mysqli_query($con, "delete from transactions where batch_id='$bidTX'");
                                   // echo "delete from transactions where batch_id='$bidTX'";

                                                        
                                    // $deleteWalletRecord = mysqli_query($con,  "DELETE FROM `wallet` WHERE `transactionID`='$bidTX'");
                                    // if($deleteWalletRecord){
                                    //     $DeleteWinHistory = mysqli_query($con,  "DELETE FROM `winning_history` WHERE `game_id`='$gameID' AND `date`='$resultDate'");   

                                    //     if($DeleteWinHistory){
                                    //         echo "<script>window.location.href='declare-result.php';</script>";
                                    //     }
                                    // }
                                    
                                    
                                                        
                                }
                                echo "<script>window.location.href='declare-result.php';</script>";
                            }
                        ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
    <style>
        
        .show-winner-table {
            padding: 10px 5px;
        }
        
    </style>
    
<!--Show Winners Model-->
  <div class="modal fade" id="showWinners">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Winners List</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="    overflow: scroll;">
            <table class="table show-winner-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Bid</th>
                        <th>Win</th>
                        <th>Market</th>
                        <th>Game</th>
                        <th>Bet</th>
                        <th>Date and Time</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody id="showWinnersTable">
                    
                </tbody>
            </table>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>

<?php include('footer.php'); ?>
<script>

$('.mobileSelect').mobileSelect({
    animation: 'scale',
    animationSpeed: 400
});

$(".btn-mobileSelect-gen").on('click', function(event){
    event.preventDefault();
});

// show declare result
    $('#go').click(function(){
        var date = $('#resultDate').val();
        var gameId = $('#gameId').val();
        var session = $('#session').val();
        var pana = $('#pana').val();
        var digit = $('#digit').val();
        
        if((date) && (gameId) && (session) && (pana) && (digit)){
            $.ajax({    //create an ajax request to 
                type: "POST",
                url: "declare-result-ajax.php",             
                data:{resultDate:date, gameID:gameId, session:session, pana:pana, digit:digit},   //expect html to be returned                
                success: function(data){
                    var obj = JSON.parse(data);
                    if(obj.result== false){
                        alert(obj.msg);
                    }else{
                        $('.center').css('display','block');
                    }
                }
            });
        }
        
});

// Show Winner list
    $('#showResult').click(function(){
        var date = $('#resultDate').val();
        var gameId = $('#gameId').val();
        var session = $('#session').val();
        var pana = $('#pana').val();
        var digit = $('#digit').val();
        
        if((date) && (gameId) && (session)){
            $.ajax({    //create an ajax request to 
                    type: "POST",
                    url: "show-winners-ajax.php",             
                    data:{date:date, market:gameId,session:session,panna:pana,digit:digit},  //expect html to be returned                
                    success: function(data){
                        $('#showWinnersTable').html(data);
                        $('#showWinners').modal('show');
                    }
                });
        }    
    });
    
// Declare Result 
$('#declareResult').click(function(){
    var date = $('#resultDate').val();
    var gameId = $('#gameId').val();
    var session = $('#session').val();
    
    if((date) && (gameId) && (session)){
        $.ajax({    //create an ajax request to 
                type: "POST",
                url: "declare-result-final.php",             
                data:{resultDate:date, gameID:gameId,session:session},   //expect html to be returned                
                success: function(data){
                    location.reload();
                }
            });
    }  
})

// Auto Calculate Digit
$('#pana').change(function(){
        var pana = $(this).val();
        var dsum = 0;
        for (var i = 0; i < pana.length; i++)
          {
        
            if (/[0-9]/.test(pana[i])) dsum += parseInt(pana[i])
          }
          var dd = dsum.toString();
          var res = dd.charAt(dd.length-1);
          
          $('#digit').val(res);
});
    
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
    
//PrevResultFilterDate
$('#PrevResultFilterDate').change(function(){
    var PrevResultdate = $('#PrevResultFilterDate').val();
    
    if(PrevResultdate != ''){
        $.ajax({    //create an ajax request to 
            type: "POST",
            url: "filter-result-ajax.php",             
            data:{resultDate:PrevResultdate},  //expect html to be returned                
            success: function(data){
                $('#tbody').html(data);
            }
        });
    }
});
</script>