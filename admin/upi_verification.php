<?php include('header.php');




if(isset($_REQUEST['complete'])){
    $sn = $_REQUEST['complete'];
    $info = mysqli_fetch_array(mysqli_query($con,"select user, amount from upi_verification where sn='$sn'"));
    $mobile = $info['user'];
    $amount = $info['amount'];
    
   mysqli_query($con,"delete from upi_verification where sn='$sn'");
    
    mysqli_query($con,"update users set wallet=wallet+'$amount' where mobile='$mobile'");

    mysqli_query($con,"INSERT INTO `transactions`( `user`, `amount`, `type`, `remark`, `owner`, `created_at`) VALUES ('$mobile','$amount','1','Deposit','user','$stamp')");
    

    
    header('location:upi_verification.php');
}


if(isset($_REQUEST['cancel'])){
    $sn = $_REQUEST['cancel'];
    
    mysqli_query($con,"delete from upi_verification where sn='$sn'");
    
    header('location:upi_verification.php');
}



$num_results_on_page = 10;  
if (isset($_GET["page"])) {
	$page  = $_GET["page"]; 
} 
else{ 
	$page=1;
};  

$start_from = ($page-1) * $num_results_on_page;  

$search_url_add = "";

$result = mysqli_query($con,"select * from upi_verification order by sn desc LIMIT $start_from, $num_results_on_page");
    
$result_db = mysqli_query($con,"SELECT COUNT(sn) FROM upi_verification"); 

$action_url = "&page=".$page.$search_url_add;


$row_db = mysqli_fetch_row($result_db);  
$total_pages = $row_db[0];  

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;




?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Deposit Points Request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Deposit Request</li>
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
                    <button class="btn btn-primary">Deposit Points</button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                     <th>#</th>
                    <th>Mobile</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Created at</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    

                    <?php
                     $i = (($page-1)*10)+1; while ($xc = mysqli_fetch_array($result)) { 
                    

                      $mobile = $xc['user'];
                      $uinfo = mysqli_fetch_array(mysqli_query($con,"select name from users where mobile='$mobile'"));

                    ?>



                    <tr>
                      <td><?php echo $i; $i++; ?></td>
                      <td><a href="user-profile.php?userID=<?php echo $user_id; ?>"><?php echo $mobile; ?><i class="mdi mdi-link"></i></td>
                      <td><?php echo $uinfo['name']; ?></td>
                      <td><?php echo $xc['amount']; ?></td>

                      <td><?php echo date('d/m/Y h:i A',$xc['created_at']); ?></td>
                      <td>
                        <a href="upi_verification.php?complete=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to proceed')">Completed</button> </a>
                        <a href="upi_verification.php?cancel=<?php echo $xc['sn']; ?>"> <button class="btn btn-outline-info" onclick="return confirm('Are you sure you want to proceed')">Cancel</button> </a>

                      </td>
                    </tr>



                    <?php } ?>
                    
                    
                  </tbody>
                </table>
                
                
                <?php if (ceil($total_pages / $num_results_on_page) > 0): 
                                    
                                     ?>
                <ul class="pagination">
                  <?php if ($page > 1): ?>
                  <li class="prev page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page-1 ?><?php echo $search_url_add; ?>">Prev</a></li>
                  <?php endif; ?>

                  <?php if ($page > 3): ?>
                  <li class="start page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=1<?php echo $search_url_add; ?>">1</a></li>
                  <li class="dots page-item">...</li>
                  <?php endif; ?>

                  <?php if ($page-2 > 0): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page-2 ?><?php echo $search_url_add; ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                  <?php if ($page-1 > 0): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page-1 ?><?php echo $search_url_add; ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                  <li class="currentpage page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page ?><?php echo $search_url_add; ?>"><?php echo $page ?></a></li>

                  <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page+1 ?><?php echo $search_url_add; ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                  <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page+2 ?><?php echo $search_url_add; ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                  <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
                  <li class="dots page-item">...</li>
                  <li class="end page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo ceil($total_pages / $num_results_on_page) ?><?php echo $search_url_add; ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
                  <?php endif; ?>

                  <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                  <li class="next page-item"><a class='page-link' href="<?php echo $_PHP_SELF; ?>?page=<?php echo $page+1 ?><?php echo $search_url_add; ?>">Next</a></li>
                  <?php endif; ?>
                </ul>
                <?php endif; ?>
                
                
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

    if(isset($_POST['requestRejected'])){
        $id = $_POST['id'];
        $remark = $_POST['remark'];
        $createDate = date("Y-m-d H:i:s");
        $txnID = $_POST['txn_id'];
        $userID = $_POST['user_id'];
        
        mysqli_query($con,"update withdraw_requests set status='2' where sn='$id'");
        
        $info = mysqli_fetch_array(mysqli_query($con,"select user, amount from withdraw_requests where sn='$id'"));
        $mobile = $info['user'];
        $amount = $info['amount'];
        
        mysqli_query($con,"UPDATE users set wallet=wallet+$amount where mobile='$mobile'");
    
        $withdrawUpdate = mysqli_query($con,"INSERT INTO `transactions`(`user`, `amount`, `type`, `remark`, `owner`, `created_at`, `game_id`, `batch_id`) VALUES ('$mobile','$amount','1','Withdraw cancelled by our team','user','$stamp','0','0')");
  
       
                                                    
        if($withdrawUpdate){
             echo "<script>window.location.href= 'withdraw-points-request.php';</script>";
            // $walletRowDelete = mysqli_query($con, "DELETE FROM `wallet` WHERE `user_id`='$userID' AND `transactionID`='$txnID'");
            // if($walletRowDelete){
            //     echo "<script>window.location.href= 'withdraw-points-request.php';</script>";
            // }
        }
    }



    // Approved request
    if(isset($_POST['requestApproved'])){
        $id = $_POST['id'];
        $remark = $_POST['remark'];
        $createDate = date("Y-m-d H:i:s");
                                                
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 // $banner_url = $_POST['banner_url'];
    
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
   
        
          $withdrawUpdate=  mysqli_query($con,"update withdraw_requests set status='1', screenshot_with='$target_file' where sn='$id'");
          echo "update withdraw_requests set status='1', screenshot_with='$banner_url' where sn='$id'";
        // $target_dir = "images/";
        // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            
        // }
                                                                
        // $withdrawUpdate = mysqli_query($con, "UPDATE `withdraw_point_request` SET `remark`='$remark',`accept_date`='$createDate',`payment_receipt`='$target_file',`status`='1' WHERE `id`='$id'");
                                                    
        if($withdrawUpdate){
           // echo "<script>window.location.href= 'withdraw-points-request.php';</script>";
        }
    }
?>

<?php include('footer.php'); ?>