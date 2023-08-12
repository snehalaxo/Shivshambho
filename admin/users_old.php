<?php include('header.php'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <a href="unapproved-users.php" class="btn btn-primary">Un-approved Users List</a>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User Name</th>
                      <th>User Mobile</th>
                      <th>Points</th>
                      <th>Points</th>
                      <th>Registration Date</th>
                      <th>Betting</th>
                      <th>Paytm</th>
                      <th>Point Transfer</th>
                      <th>Active</th>
                      <th>View</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $user = mysqli_query($con, "SELECT * FROM `users` ORDER BY sn DESC");
                    $i = 1;
                    while($row = mysqli_fetch_array($user)){
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row['name']; ?></td>
                      <td>
                        <?php echo $row['mobile']; ?><br>
                        <a href="https://api.whatsapp.com/send?phone=91<?php echo $row['mobile']; ?>" target="_blank"><i class="fab fa-whatsapp" style="color:green;font-size:20px;"></i></a>
                        &nbsp;&nbsp;
                        <a href="tel:+91 <?php echo $row['mobile']; ?>" target="_blank"><i class="fas fa-phone-alt" style="font-size:20px;"></i></a>
                      </td>
                      <td><?php echo $row['wallet']; ?>    </td>
                      <td>  <a href="#addPoint<?php echo $row['mobile']; ?>" data-toggle="modal" class="btn btn-success btn-sm">Add Points</a>
                        
                        <a href="#withdrowPoints<?php echo $row['mobile']; ?>" data-toggle="modal" class="btn btn-danger btn-sm">Withdraw Points</a></td>
                      <td><?php echo date('d-m-Y',$row['created_at']); ?></td>
                      <td>
                        <?php
                          if($row['verify'] == 0){
                        ?>
                          <a href="users.php?BettingActive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-danger">No</a>
                        <?php
                          }else{
                        ?>
                          <a href="users.php?BettingDeactive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-success">Yes</a>
                        <?php
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if($row['paytm'] == 0){
                        ?>
                          <a href="users.php?paytmActive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-danger">No</a>
                        <?php
                          }else{
                        ?>
                          <a href="users.php?paytmDeactive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-success">Yes</a>
                        <?php
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if($row['transfer_points_status'] == 1){
                        ?>
                          <a href="users.php?TransferDeactive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-success">Yes</a>
                        <?php
                          }else{
                        ?>
                          <a href="users.php?TransferActive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-danger">No</a>
                        <?php
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if($row['active'] == 0){
                        ?>
                            <a href="users.php?UserActive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-danger">No</a>
                        <?php
                          }else{
                        ?>
                            <a href="users.php?UserDeactive=<?php echo $row['sn']; ?>" class="btn btn-sm btn-success">Yes</a>
                        <?php
                          }
                        ?>
                      </td>
                      <td>
                        <a href="user-profile.php?userID=<?php echo $row['mobile']; ?>"><i class="fas fa-eye" style="font-size:25px;"></i></a>
                        
                       
                                        </div>
                      </td>
                    </tr>
                    
                                       
<!--Withdrawal Points-->
<div class="modal fade" id="withdrowPoints<?php echo $row['mobile']; ?>">
        <div class="modal-dialog">
          <div class="modal-content">
          
         
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Withdraw Points</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" autocomplete="off">
                    <input type="hidden" name="user_id" value="<?php echo $row['mobile']; ?>" />
                    <div class="form-group">
                        <label>Withdraw Points</label>
                        <input type="number" name="pointsWithdwaw" value="" class="form-control" placeholder="Enter Points Here" required/>
                    </div>
                    
                    <div class="form-group">
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit" name="WithdwawPoints">Submit</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
               
            </div>
          </div>
        </div>
      </div>

<!--Add Points-->
    <div class="modal fade" id="addPoint<?php echo $row['mobile']; ?>">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Add Points</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" autocomplete="off">
                    
                    <input type="hidden" name="user_id" value="<?php echo $row['mobile']; ?>" />
                    <div class="form-group">
                        <label>Add Points</label>
                        <input type="number" name="pointsAdd" value="" class="form-control" placeholder="Enter Points Here" required />
                    </div>
                    
                    <div class="form-group">
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit" name="AddPoints">Submit</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
             
            </div>
          </div>
        </div>
      </div>
      
      
                  <?php
                    $i++;  
                    }

                    // Active Transfer Status
                    if(isset($_GET['paytmActive'])){
                        $id = $_GET['paytmActive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `paytm`='1' WHERE `sn`='$id'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
                    }
                    
                    // Deactive Transfer Status
                    if(isset($_GET['paytmDeactive'])){
                        $id = $_GET['paytmDeactive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `paytm`='0' WHERE `sn`='$id'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
                    }
                    
                    // Active Transfer Status
                    if(isset($_GET['TransferActive'])){
                        $id = $_GET['TransferActive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `transfer_points_status`='1' WHERE `sn`='$id'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
                    }
                    
                    // Deactive Transfer Status
                    if(isset($_GET['TransferDeactive'])){
                        $id = $_GET['TransferDeactive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `transfer_points_status`='0' WHERE `sn`='$id'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
                    }
                    
                    // Active Betting Status
                    if(isset($_GET['BettingActive'])){
                        $id = $_GET['BettingActive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `verify`='1' WHERE `sn`='$id' AND `verify`='0'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
                    }
                    
                    // Deactive Betting Status
                    if(isset($_GET['BettingDeactive'])){
                        $id = $_GET['BettingDeactive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `verify`='0' WHERE `sn`='$id' AND `verify`='1'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
                    }
                    
                    
                    // Active User Status
                    if(isset($_GET['UserActive'])){
                        $id = $_GET['UserActive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `active`='1' WHERE `user_id`='$id' AND `active`='0'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
                    }
                    
                    // Deactive User Status
                    if(isset($_GET['UserDeactive'])){
                        $id = $_GET['UserDeactive'];
                        $registrationDate = date("Y-m-d H:i:s");
                        
                        $updateUser = mysqli_query($con, "UPDATE `users` SET `active`='0' WHERE `user_id`='$id' AND `active`='1'");
                        if($updateUser){
                            echo "<script>window.location.href='users.php';</script>";
                        }
                        
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

    <?php
                    if(isset($_POST['WithdwawPoints'])){
                        $user_id = $_POST['user_id'];
                        $pointsAdd = $_POST['pointsWithdwaw'];
                        $createDate = date("Y-m-d H:i:s");
                        $dateString = date('Ymd');
                        $fourRandomDigit = rand(1000,9999);
                        $TXN = 'TXN'.$dateString.$fourRandomDigit;
                        
                        $stamp = time();
                        
                        $walletAdd = mysqli_query($con,"update users set wallet=wallet-'$pointsAdd' where mobile='$user_id'");
                        mysqli_query($con,"INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`owner`) VALUES ('$user_id','$pointsAdd','0','Points Withdraw By Admin','$stamp','admin@gmail.com')");
         
                        
                        // $walletAdd = mysqli_query($con, "INSERT INTO `wallet`(`user_id`, `balance`, `operator`, `transactionID`, `description`, `created_at`) 
                        //                                     VALUES ('$user_id','$pointsAdd','-','$TXN', 'Points Withdraw By Admin', '$createDate')");
            
                            if($walletAdd){
                                echo "<script>window.location.href= '';</script>";
                            }
                    }
                ?>
                
                 <?php
                    if(isset($_POST['AddPoints'])){
                      
                        $user_id = $_POST['user_id'];
                      
                        $pointsAdd = $_POST['pointsAdd'];
                        $createDate = date("Y-m-d H:i:s");
                        $dateString = date('Ymd');
                        $fourRandomDigit = rand(1000,9999);
                        $TXN = 'TXN'.$dateString.$fourRandomDigit;
                        
                      if($_SESSION['userID'] != $main_admin_mail){
                       
                        if(mysqli_num_rows(mysqli_query($con,"select sn from admin where wallet >= $pointsAdd AND email='".$_SESSION['userID']."'")) == 0){
                          
                       //   echo "<script>alert('select sn from admin where wallet >= $pointsAdd' AND email='".$_SESSION['userID']."');</script>";
                          
                          echo "<script>window.location.href= 'user-profile.php?userID=".$user_id."&error=You%20dont%20have%20enough%20wallet%20balance';</script>";
                          
                          return;
                          
                        } else {
                       
                          $walletAdd = mysqli_query($con,"update admin set wallet=wallet-$pointsAdd where email='".$_SESSION['userID']."'");
                          
                          mysqli_query($con,"INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES ('".$_SESSION['userID']."','$pointsAdd','0','Deposit to user $user_id','".$_SESSION['userID']."','$stamp','0','0')");
                        }
                        
                      }
                        
                        $stamp = time();
                        
                       $walletAdd = mysqli_query($con,"update users set wallet=wallet+'$pointsAdd' where mobile='$user_id'");
                        mysqli_query($con,"INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `created_at`,`owner`) VALUES ('$user_id','$pointsAdd','1','Points Added By Admin','$stamp','admin@gmail.com')");
         
                        
                        // $walletAdd = mysqli_query($con, "INSERT INTO `wallet`(`user_id`, `balance`, `operator`, `transactionID`, `description`, `created_at`) 
                        //                                     VALUES ('$user_id','$pointsAdd','+','$TXN', 'Points Added By Admin', '$createDate')");
            
                            if($walletAdd){
                                echo "<script>window.location.href= '';</script>";
                            }
                    }
                ?>
<?php include('footer.php'); ?>