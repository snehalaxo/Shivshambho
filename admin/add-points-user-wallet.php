<?php include('header.php'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Points (User Wallet)</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Add Points (User Wallet)</li>
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
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <form method="post">
                            <div class="form-group">
                                <label>Users</label>
                                <select name="user_id" class="form-control select2bs4" style="width: 100%;">
                                    <option value="" disabled selected>Select User</option>
                                    <?php
                                        $user = mysqli_query($con, "SELECT * FROM `users` ORDER BY sn ASC ");
                                        while($row = mysqli_fetch_array($user)){
                                    ?>
                                        <option value="<?php echo $row['mobile']; ?>"><?php echo $row['name']; ?> (<?php echo $row['mobile']; ?>)</option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Points</label>
                                <input type="number" name="points" min="0" class="form-control" placeholder="Enter Points" required/>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="AddPoints" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3"></div>
                </div>
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


    if(isset($_POST['AddPoints'])){
                                        
        $user_id = $_POST['user_id'];
        $points = $_POST['points'];
                                        
        $createDate = date("Y-m-d H:i:s");
                                        
        $dateString = date('Ymd');
        $fourRandomDigit = rand(1000,9999);
        $TXN = 'TXN'.$dateString.$fourRandomDigit;
        
        
        mysqli_query($con,"UPDATE users set wallet=wallet+$points where mobile='$user_id'");
        $walletAdd = mysqli_query($con,"INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES ('$user_id','$points','1','Points Added By Admin','admin@gmail.com','$stamp','0','0')");
  
     
                                        
      //  $walletAdd = mysqli_query($con, "INSERT INTO `wallet`(`user_id`, `balance`, `operator`, `transactionID`, `description`, `created_at`) 
         //                                           VALUES ('$user_id','$points','+','$TXN', 'Points Added By Admin', '$createDate')");
            
            if($walletAdd){
                echo "<script>window.location.href= 'add-points-user-wallet.php';</script>";
            }
    }




include('footer.php'); ?>

<script>
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>